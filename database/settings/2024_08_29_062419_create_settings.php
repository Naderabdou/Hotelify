<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.site_name_ar', 'Hotelify');
        $this->migrator->add('general.site_name_en', 'Hotelify');


        $this->migrator->add('general.logo', 'settings\/01JV8FF64BK5N15X7GRXJCS7MD.png');



        $this->migrator->add('general.favicon', 'settings\/01JV8FF64BK5N15X7GRXJCS7MD.png');



        $this->migrator->add('general.phone', '01147507444');
        $this->migrator->add('general.email', 'abdounader04@gmail.com');
        $this->migrator->add('general.whatsapp', '01147507444');
        $this->migrator->add('general.facebook', 'https://www.facebook.com/');
        $this->migrator->add('general.instagram', 'https://www.instagram.com/');
        $this->migrator->add('general.address', '');
        $this->migrator->add('general.location', '');
    }
};
