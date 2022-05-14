<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        ini_set("memory_limit", -1);
        ini_set("max_execution_time", 0);

        Schema::disableForeignKeyConstraints();

        $this->call([
            MenuCategorySeeder::class,
            MenuSeeder::class,

            RoleSeeder::class,
            AccessSeeder::class,
            AccessMenuSeeder::class,
            AdminSeeder::class,

            SettingSeeder::class,
            LogSeeder::class,

            ContactSeeder::class,

            RepositorySubjectSeeder::class,
            RepositorySeeder::class,
            RepositoryFileSeeder::class,
            RepositoryContributorSeeder::class,

            LecturerSeeder::class,
            LecturerEducationSeeder::class,
            LecturerWorkExperienceSeeder::class,

            CourseSeeder::class,
            CourseLecturerSeeder::class,

            StudyProgramCategorySeeder::class,
            StudyProgramSeeder::class,

            NewsCategorySeeder::class,
            NewsSeeder::class,
            NewsCommentSeeder::class,

            FaqCategorySeeder::class,
            FaqSeeder::class,

            GallerySeeder::class,
            MagazineSeeder::class,
            BannerSeeder::class,
            SliderSeeder::class,
            TestimonySeeder::class,
            ValueSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
