# Service Ecosystem Stage Filtering

Status: In progress

## Steps:
- [x] 1. Update app/Helpers/ServiceEcosystem.php with user-specified professions for Planning Stage (1.1, 1.2) and Designing Stage
- [x] 2. Add substage param to route/controller (e.g. /ecosystem/stage/1/planning)
- [x] 3. Update ServiceEcosystemController query: where('stage', $stage)->whereIn('profession', $substageProfessions)
- [ ] 4. Update view to show substage name
- [x] 5. Run `php artisan optimize:clear`
- [ ] 6. Seed demo data if needed & test /ecosystem/stage/1/planning

