### Improvements
- Add confirm password in users edit
- Add Metrics to Dashboard homepage
- Add TextAreaColumn for Comment Relation Manager in tasks

### Seed Configuration
`php artisan migrate:fresh --seed` Creates the roles and the users
`php artisan db:seed DummyDataSeeder` This is optional.

### Decisions Made
 - Didn't create task_dependencies table because I believe the NxN relationship between tasks are not optimal. A task_id in tasks table was enough for the parent - child relationship. Its my personal opinion to not accept multiple parent tasks relations, only multiple childs.
  - Renamed project_members  to project_user for couple reasons: (Laravel code convention says that we should use the resources in singular, and alphabetical order. Second reason was to avoid using alias in DB)
