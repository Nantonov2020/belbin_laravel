<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeTestCompany();
        $this->makeTestDepartment();
        $this->makeTestUserForTestWorker();
        $this->makeTestUserForTestHR();
        $this->makeTestWorker();
        $this->makeTestHR();
    }

    private function makeTestCompany():void
    {
        DB::table('companies')->insert(['name' => 'TestCompany']);
    }

    private function makeTestDepartment():void
    {
        $testCompany = Company::where('name','TestCompany')->first();
        DB::table('departments')->insert(['name' => 'TestDepartment', 'company_id' => $testCompany->id]);
    }

    private function makeTestUserForTestWorker():void
    {
        DB::table('users')->insert(['name' => 'TestUser', 'email' => 'TestUser@TestUser.biz', 'password' => '111']);
    }

    private function makeTestUserForTestHR():void
    {
        DB::table('users')->insert(['name' => 'TestHR', 'email' => 'TestHR@TestHR.biz', 'password' => '111']);
    }

    private function makeTestWorker():void
    {
        $testUser = User::where('name','TestUser')->first();
        $testDepartment = Department::where('name','TestDepartment')->first();

        DB::table('workers')->insert(['user_id' => $testUser->id, 'department_id' => $testDepartment->id]);
    }

    private function makeTestHR():void
    {
        $testHR = User::where('name','TestHR')->first();
        $testCompany = Company::where('name','TestCompany')->first();

        DB::table('hrworkers')->insert(['user_id' => $testHR->id, 'company_id' => $testCompany->id]);
    }
}
