<?php


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(RolesAndPermissionSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BrandsTableSeeder::class);
        $this->call(ProductTypesTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CartsTableSeeder::class);
        $this->call(ArticlesSeeder::class);        
        Model::reguard();
    }
}