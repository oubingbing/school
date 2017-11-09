<?php

namespace Tests\Unit;

use App\Colleges;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function demo()
    {
        $schools = DB::table('school')->get();

        $arr = [];
        foreach ($schools as $item){
            array_push($arr,[
                Colleges::FIELD_NAME=>$item->name,
                Colleges::FIELD_TYPE=>$item->type,
                Colleges::FIELD_PROVINCE=>$item->province,
                Colleges::FIELD_PROPERTIES=>$item->properties,
                Colleges::FIELD_CREATED_AT=>Carbon::now(),
                Colleges::FIELD_UPDATED_AT=>Carbon::now()
            ]);
        }

        Colleges::insert($arr);

    }
}
