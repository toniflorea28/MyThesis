<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use App\Models\Message;
use App\Models\Pricing;
use App\Models\PricingBenefit;
use Database\Factories\JobCategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use App\Models\Job;
class DatabaseSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsersToCreate = 50;

//        User::factory()
//            ->count($numberOfUsersToCreate)
//            ->create();

//        DB::table('users')->insert([
//            'fullName' => 'Admin',
//            'email' => 'admin@mythesis.ro',
//            'username' => 'mythesis',
//            'avatar' => 'user.jpg',
//            'role' => 'admin',
//            'ability' => '{"action": "manage", "subject": "all"}',
//            'available' => 0,
//            'referral' =>  '0000-0000-0000-0000',
//            'email_verified_at' => now(),
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//            'remember_token' => Str::random(10),
//        ]);

        JobCategory::factory()
            ->count(sizeof(JobCategoryFactory::$jobCategories)-1)
            ->create();


//        Message::factory()
//            ->count(150)
//            ->create();

//        Job::factory()
//            ->count($numberOfUsersToCreate)
//            ->create();

        Pricing::factory()
            ->count(3)
            ->create();

        $options = [
            1 => [
                '30 contacte incluse',
                'Acces la sistemul de recenzii Workbook',
                'Acces la chat privat al??turi de contactele tale',
                'Cashback prin referral. Primesti 20% din banii pe care o persoana invitat?? ??i folose??te pentru achizitonarea unui abonament, ??i 10% daca acea persoana invit?? alte persoane',
                'Limit?? de retragere de pe platforma: 25$'
            ],
            2 => [
                'Toate beneficiile pachetului Basic',
                'Contacte nelimitate',
                'Po??i l??sa mesaje tuturor utilizatorilor.',
                'Po??i ??nc??rca imagini de dimensiuni mai mari (pana la 2GB total, pentru toate anun??urile postate)',
                'Cashback prin referral. Primesti 25% din banii pe care o persoana invitat?? ??i folose??te pentru achizitonarea unui abonament, ??i 15% daca acea persoana invit?? alte persoane'
            ],
            3 => [
                'Toate beneficiile pachetelor Basic ??i Standard',
                'Po??i ??nc??rca imagini de dimensiuni mai mari (pana la 5GB total, pentru toate anun??urile postate)',
                'Cashback prin referral. Primesti 30% din banii pe care o persoana invitat?? ??i folose??te pentru achizitonarea unui abonament, ??i 20% daca acea persoana invit?? alte persoane'
            ]
        ];

        foreach ($options as $pricingId => $descriptions) {
            foreach ($descriptions as $description) {
                DB::table('pricing_benefits')->insert([
                    'pricing_id' => $pricingId,
                    'description' => $description,
                ]);
            }
        }

        // Q And A

        $qandA = [
            [
                'question' => 'Does my subscription automatically renew?',
                'answer' => 'Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.',
            ],
            [
                'question' => 'Can I store the item on an intranet so everyone has access?',
                'answer' => 'Tiramisu marshmallow dessert halvah bonbon cake gingerbread. Jelly beans chocolate pie powder. Dessert pudding chocolate cake bonbon bear claw cotton candy cheesecake. Biscuit fruitcake macaroon carrot cake. Chocolate cake bear claw muffin chupa chups pudding.',
            ],
            [
                'question' => 'Am I allowed to modify the item that I purchased?',
                'answer' => 'Tart gummies drag??e lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans souffl?? cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet muffin chocolate candy pie tootsie roll marzipan. Carrot cake marshmallow pastry. Bonbon biscuit pastry topping toffee dessert gummies. Topping apple pie pie croissant cotton candy dessert tiramisu.',
            ],
        ];

        DB::table('qanda')->insert($qandA);
    }
}
