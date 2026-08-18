<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Settings extends Page
{
    use WithFileUploads;

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 99;

    protected static ?string $title = 'Pengaturan';

    protected static ?string $slug = 'settings';

    protected string $view = 'filament.pages.settings';


    /*
    |--------------------------------------------------------------------------
    | Identitas
    |--------------------------------------------------------------------------
    */

    public ?string $school_name = null;

    public ?string $tefa_name = null;

    public ?string $department_name = null;


    /*
    |--------------------------------------------------------------------------
    | Kontak
    |--------------------------------------------------------------------------
    */

    public ?string $address = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $website = null;


    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    public $school_logo = null;

    public $tefa_logo = null;


    /*
    |--------------------------------------------------------------------------
    | Penanggung Jawab
    |--------------------------------------------------------------------------
    */

    public ?int $head_program_id = null;

    public ?int $treasurer_id = null;


    /*
    |--------------------------------------------------------------------------
    | Load Pengaturan
    |--------------------------------------------------------------------------
    */

    public function mount(): void
    {
        $setting = Setting::firstOrCreate([
            'id' => 1,
        ]);

        $this->school_name = $setting->school_name;

        $this->tefa_name = $setting->tefa_name;

        $this->department_name = $setting->department_name;


        $this->address = $setting->address;

        $this->phone = $setting->phone;

        $this->email = $setting->email;

        $this->website = $setting->website;


        $this->school_logo = $setting->school_logo;

        $this->tefa_logo = $setting->tefa_logo;


        $this->head_program_id = $setting->head_program_id;

        $this->treasurer_id = $setting->treasurer_id;
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Pengaturan
    |--------------------------------------------------------------------------
    */

    public function save(): void
    {
        $setting = Setting::firstOrCreate([
            'id' => 1,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Logo Sekolah
        |--------------------------------------------------------------------------
        */

        $schoolLogo = $setting->school_logo;

        if (
            $this->school_logo instanceof
            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
        ) {

            if ($schoolLogo) {
                Storage::disk('public')->delete($schoolLogo);
            }

            $schoolLogo = $this->school_logo->store(
                'settings',
                'public'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Logo TEFA
        |--------------------------------------------------------------------------
        */

        $tefaLogo = $setting->tefa_logo;

        if (
            $this->tefa_logo instanceof
            \Livewire\Features\SupportFileUploads\TemporaryUploadedFile
        ) {

            if ($tefaLogo) {
                Storage::disk('public')->delete($tefaLogo);
            }

            $tefaLogo = $this->tefa_logo->store(
                'settings',
                'public'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Database
        |--------------------------------------------------------------------------
        */

        $setting->update([

            'school_name' => $this->school_name,

            'tefa_name' => $this->tefa_name,

            'department_name' => $this->department_name,


            'address' => $this->address,

            'phone' => $this->phone,

            'email' => $this->email,

            'website' => $this->website,


            'school_logo' => $schoolLogo,

            'tefa_logo' => $tefaLogo,


            'head_program_id' => $this->head_program_id,

            'treasurer_id' => $this->treasurer_id,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan Path Logo ke Property
        |--------------------------------------------------------------------------
        */

        $this->school_logo = $schoolLogo;

        $this->tefa_logo = $tefaLogo;


        /*
        |--------------------------------------------------------------------------
        | Notifikasi
        |--------------------------------------------------------------------------
        */

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}