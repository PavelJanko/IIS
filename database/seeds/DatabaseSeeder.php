<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        static $departmentCount = 6;
        static $roomCount = 100;
        static $employeeCount = 75;
        static $deviceCount = 250;
        static $repairCount = 500;

        $this->command->info('Seeding departments...');
        factory(App\Department::class, $departmentCount)->create();

        $this->command->info('Seeding rooms and associating them with departments...');
        factory(App\Room::class, $roomCount)->create();

        $this->command->info(
            'Resetting cached roles and permissions, '
            . 'seeding roles and attaching permissions to them...'
        );

        app()['cache']->forget('spatie.permission.cache');
        Permission::create(['name' => 'assign manager role']);
        $employeeManagement = Permission::create(['name' => 'manage employees']);

        $adminRole = Role::create(['name' => 'administrátor']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::create(['name' => 'manažer']);
        $managerRole->givePermissionTo($employeeManagement);

        $this->command->info('Seeding employees and associating them with departments and rooms...');
        factory(App\Employee::class, $employeeCount)->create()
            ->each(function ($employee) use ($roomCount) {
                /**
                 * The loop keeps going until it finds a non-CVT room for the employee,
                 * because there can be no employees with offices inside CVT classrooms.
                 */
                while (($employee->room_id = rand(1, $roomCount)) && App\Room::find($employee->room_id)->isInCVT())
                    ;

                $employee->department_id = $employee->room->department->id;
                $employee->updated_at = $employee->created_at->addDays(15);

                if ($employee->id === 1) {
                    $employee->assignRole('administrátor');
                    $employee->username = 'test.admin';
                } else if ($employee->id === 2) {
                    $employee->assignRole('manažer');
                    $employee->username = 'test.manager';
                } else if ($employee->id === 3)
                    $employee->username = 'test.employee';
                else {
                    if (!rand(0, 9))
                        $employee->assignRole('administrátor');
                    else if (!rand(0, 5))
                        $employee->assignRole('manažer');
                }

                $employee->update();
            });

        $this->command->info('Seeding devices, associating them with keepers and sometimes rooms...');
        factory(App\Device::class, $deviceCount)->create()
            ->each(function ($device) use ($roomCount) {
                $roomId = rand(1, $roomCount);

                // If the device is inside the CVT, assign a room to it.
                if (App\Room::find($roomId)->isInCVT())
                    $device->room_id = $roomId;

                $device->update();
            });

        $this->command->info('Seeding repairs and associating them with devices, etc...');
        factory(App\Repair::class, $repairCount)->create()
            ->each(function ($repair) use ($deviceCount, $employeeCount) {
                // The claimant and repairer shouldn't be the same person.
                while (($repair->repairer_id = rand(1, $employeeCount)) == $repair->claimant_id)
                    ;

                $repair->claimed_at = \Carbon\Carbon::now()->subDays(15);

                $repair->repaired_at = date('Y-m-d h:m:s', rand(
                    $repair->claimed_at->getTimestamp(), \Carbon\Carbon::now()->addDays(15)->timestamp
                ));

                $repair->update();
            });

        foreach (App\Device::all() as $device) {
            if ($device->repairs->count()) {
                $lastRepair = $device->repairs()->orderBy('repaired_at', 'desc')->first();

                $lastRepair->state = rand(0, 1) ? 'Čekající' : 'Prováděna';
                $lastRepair->claimed_at = $lastRepair->repaired_at;
                $lastRepair->repaired_at = NULL;
                $lastRepair->repairer_id = NULL;

                $lastRepair->update();
            }
        }
    }
}
