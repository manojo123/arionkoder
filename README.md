### Improvements to consider:
- Add confirm password in users edit
- Add Metrics to Dashboard homepage

### Seed Configuration
`php artisan migrate:fresh --seed` Creates the roles and the users
`php artisan db:seed DummyDataSeeder` This is optional.

### Decisions Made
- Didn't create task_dependencies table because I believe the NxN relationship between tasks are not optimal. A task_id in tasks table was enough for the parent - child relationship. Its my personal opinion to not accept multiple parent tasks relations, only multiple childs.
- Renamed project_members  to project_user for couple reasons: (Laravel code convention says that we should use the resources in singular, and alphabetical order. Second reason was to avoid using alias in DB)
- I used the built-in Authentication & Authorization from Filament

### Notification Configuration
In order to make notifications work, you have to run the command `sail artisan queue:work`. Notifications will trigger when you create or edit Projects and Tasks from an user different from the manager itself. After user (can be admin or member) edits it, manager will receive the notification.

### API Configuration
Since I am using Filament, I configured `Laravel Sanctum` + the plugin `rupadana-api-service` that does all the work for building the API resources for Laravel.
- To generate token for admin user with full privileges type `sail artisan api:token`
- The API only consider `Users`, `Organizations`, `Projects`, `Tasks`, Using the standard routes for Rest APIs
```
GET	/api/users	Return LengthAwarePaginator
GET	/api/users/1	Return single resource
PUT	/api/users/1	Update resource
POST	/api/users	Create resource
DELETE	/api/users/1	Delete resource
```
- Set the token as Bearer token. Below you can find an example of Request
```
curl --location 'http://laravel.test/api/users' \
--header 'Authorization: MY_GENERATED_TOKEN'
```
