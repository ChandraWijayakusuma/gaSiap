namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\DepartemenKelas;

class DepartemenKelasSeeder extends Seeder
{
    public function run()
    {
        $kelas = Kelas::first();

        DepartemenKelas::create([
            'kelas_id' => $kelas->id,
            'departemen' => 'Ilmu Petir',
        ]);
    }
}
