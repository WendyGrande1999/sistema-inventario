<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $role1 = Role::firstOrCreate(['name' => 'admin']);
        $role2 = Role::firstOrCreate(['name' => 'escritor']);
    
        $user = User::find(1);
    
        if ($user) {
            $user->assignRole($role1);
        }

        $user2 = User::find(2);
        if ($user2) {
            $user2->assignRole($role1); // Asigna el rol 'admin' al usuario con ID 2
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
