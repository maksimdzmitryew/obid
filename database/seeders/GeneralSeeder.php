<?php

use App\File;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File as EloquentFile;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Setting::class)->create([
            'name' => 'phone',
            'value' => '+41 (0) 61 263 35 35'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'facebook',
            'value' => 'facebook.com'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'youtube',
            'value' => 'youtube.com'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'instagram',
            'value' => 'instagram.com'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'email',
            'value' => 'info@culturescapes.ch'
        ]);

        factory(App\Setting::class)->create([
            'name' => 'address',
            'is_translatable' => 1,
            'en' => [
                'translated_value' => '<p>Schwarzwaldallee 200</p>
                <p>CH-4058, Basel, Switzerland</p>'
            ],
            'de' => [
                'translated_value' => '<p>de Schwarzwaldallee 200</p>
                <p>de CH-4058, Basel, Switzerland</p>'
            ]
        ]);

        echo "finished settings \n";

        Role::create(['name' => 'admin']);

        factory(App\User::class)->create([
            'email' => 'admin@culturescapes.ch',
            'password' => bcrypt('password')
        ])->assignRole('admin');

        factory(App\User::class, 50)->create();

        echo "finished users \n";

        factory(App\Artist::class, 50)->create();

        echo "finished artists \n";

        factory(\App\Artist::class, 4)->create(['team_member' => 1])->each(function($artist) {
            $artist->attachImage(factory(\App\File::class)->create()->id);
        });

        echo "finished team_members \n";

        factory(\App\Artist::class, 4)->create(['board_member' => 1])->each(function($artist) {
            $artist->attachImage(factory(\App\File::class)->create()->id);
        });

        echo "finished board_members \n";

        
        foreach (factory(App\City::class, 10)->create() as $city) {
            for ($i = 0; $i < 5; $i++) {
                $places[] = factory(App\Place::class)->create(['city_id' => $city->id]);
            }
        }

        $places = collect($places);

        echo "Finished seeding Cities\n";

        $festivals = collect([
            factory(App\Festival::class)->create([
                'year' => '2019',
                'active' => 1,
                'slider_id' => function() {
                    $slider = factory(App\Slider::class)->create();
                    factory(App\Slide::class)->create(['slider_id' => $slider->id])
                        ->attachImage(factory(\App\File::class)->create()->id);
                    echo "finished 1st slider \n";
                    return $slider->id;
                },
                'en' => [
                    'name' => 'Poland',
                    'slug' => 'poland-2019',
                ],
                'de' => [
                    'name' => 'Polen',
                    'slug' => 'polen-2019'
                ],
            ])->attachImage(factory(\App\File::class)->create()->id),
            factory(App\Festival::class)->create([
                'year' => '2017',
                'slider_id' => function() {
                    $slider = factory(App\Slider::class)->create();
                    factory(App\Slide::class)->create(['slider_id' => $slider->id])
                        ->attachImage(factory(\App\File::class)->create()->id);
                    echo "finished 2 slider \n";
                    return $slider->id;
                },
                'en' => [
                    'name' => 'Greece',
                    'slug' => 'greece-2017'
                ],
                'de' => [
                    'name' => 'Griechenland',
                    'slug' => 'griechenland-2017'
                ]
            ])->attachImage(factory(\App\File::class)->create()->id),
            factory(App\Festival::class)->create([
                'year' => '2015',
                'slider_id' => function() {
                    $slider = factory(App\Slider::class)->create();
                    factory(App\Slide::class)->create(['slider_id' => $slider->id])
                        ->attachImage(factory(\App\File::class)->create()->id);

                    echo "finished 3 slider \n";
                    return $slider->id;
                },
                'en' => [
                    'name' => 'Iceland',
                    'slug' => 'iceland-2015'
                ],
                'de' => [
                    'name' => 'Island',
                    'slug' => 'island-2015'
                ]
            ])->attachImage(factory(\App\File::class)->create()->id),
            // factory(App\Festival::class)->create([
            //     'year' => '2014',
            //     'en' => [
            //         'name' => 'Tokyo',
            //         'slug' => 'tokyo-2014-en'
            //     ],
            //     'de' => [
            //         'name' => 'Tokyo',
            //         'slug' => 'tokyo-2014-de'
            //     ]
            // ]),
            // factory(App\Festival::class)->create([
            //     'year' => '2013',
            //     'en' => [
            //         'name' => 'Balkans',
            //         'slug' => 'balkans-2013'
            //     ],
            //     'de' => [
            //         'name' => 'Balkan',
            //         'slug' => 'balkan-2013'
            //     ]
            // ]),
            // factory(App\Festival::class)->create([
            //     'year' => '2012',
            //     'en' => [
            //         'name' => 'Moscow',
            //         'slug' => 'moscow-2012'
            //     ],
            //     'de' => [
            //         'name' => 'Moskau',
            //         'slug' => 'moskau-2012'
            //     ]
            // ]),
            // factory(App\Festival::class)->create([
            //     'year' => '2011',
            //     'en' => [
            //         'name' => 'Israel',
            //         'slug' => 'israel-2011'
            //     ],
            //     'de' => [
            //         'name' => 'Izrael',
            //         'slug' => 'izrael-2011'
            //     ]
            // ]),
            // factory(App\Festival::class)->create([
            //     'year' => '2010',
            //     'en' => [
            //         'name' => 'China',
            //         'slug' => 'china-2010-en'
            //     ],
            //     'de' => [
            //         'name' => 'China',
            //         'slug' => 'china-2011-de'
            //     ]
            // ]),
            // factory(App\Festival::class)->create([
            //     'year' => '2009',
            //     'en' => [
            //         'name' => 'Azerbaijan',
            //         'slug' => 'azerbaijan-2009'
            //     ],
            //     'de' => [
            //         'name' => 'Aserbaidschan',
            //         'slug' => 'aserbaidschan-2009'
            //     ]
            // ]),
        ]);

        echo "Finished seeding Festivals\n";

        $news_categories = collect([
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Art', 'slug' => 'art'],
                'de' => ['name' => 'Kunst', 'slug' => 'kunst']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Culinary', 'slug' => 'culinary'],
                'de' => ['name' => 'Kulinarisch', 'slug' => 'kulinarisch']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Dance', 'slug' => 'dance'],
                'de' => ['name' => 'Tanzen', 'slug' => 'tanzen']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Film', 'slug' => 'film'],
                'de' => ['name' => 'Film', 'slug' => 'film']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Focus', 'slug' => 'focus'],
                'de' => ['name' => 'Fokus', 'slug' => 'fokus']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'literature', 'slug' => 'literature'],
                'de' => ['name' => 'literatur', 'slug' => 'literatur']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Music', 'slug' => 'music'],
                'de' => ['name' => 'Musik', 'slug' => 'Musik']
            ]),
            factory(App\Category::class)->create([
                'type' => 'news',
                'en' => ['name' => 'Theatre', 'slug' => 'theatre'],
                'de' => ['name' => 'Theater', 'slug' => 'theater']
            ])
        ]);

        echo "Finished seeding News Categories\n";

        $event_categories = collect([
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Art', 'slug' => 'art'],
                'de' => ['name' => 'Kunst', 'slug' => 'kunst']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Culinary', 'slug' => 'culinary'],
                'de' => ['name' => 'Kulinarisch', 'slug' => 'kulinarisch']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Dance', 'slug' => 'dance'],
                'de' => ['name' => 'Tanzen', 'slug' => 'tanzen']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Film', 'slug' => 'film'],
                'de' => ['name' => 'Film', 'slug' => 'film']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Focus', 'slug' => 'focus'],
                'de' => ['name' => 'Fokus', 'slug' => 'fokus']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'literature', 'slug' => 'literature'],
                'de' => ['name' => 'literatur', 'slug' => 'literatur']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Music', 'slug' => 'music'],
                'de' => ['name' => 'Musik', 'slug' => 'Musik']
            ]),
            factory(App\Category::class)->create([
                'type' => 'events',
                'en' => ['name' => 'Theatre', 'slug' => 'theatre'],
                'de' => ['name' => 'Theater', 'slug' => 'theater']
            ])
        ]);

        echo "finished event categories \n";

        $partner_categories = collect([
            factory(App\Category::class)->create([
                'type' => 'partners',
                'en' => [
                    'name' => 'Partners',
                    'slug' => 'partners'
                ],
                'de' => [
                    'name' => 'Partner',
                    'slug' => 'partner'
                ],
            ]),
            factory(App\Category::class)->create([
                'type' => 'partners',
                'en' => [
                    'name' => 'Sponsors',
                    'slug' => 'sponsors'
                ],
                'de' => [
                    'name' => 'Sponsoren',
                    'slug' => 'sponsoren'
                ],
            ]),
            factory(App\Category::class)->create([
                'type' => 'partners',
                'en' => [
                    'name' => 'Media Partners',
                    'slug' => 'media-partners'
                ],
                'de' => [
                    'name' => 'Medienpartner',
                    'slug' => 'medienpartner'
                ],
            ])
        ]);

        echo "finished partner categories \n";

        
        $press_release_category = factory(App\Category::class)->create([
            'type' => 'presses',
            'en' => [
                'name' => 'Press releases',
                'slug' => 'press-releases'
            ],
            'de' => [
                'name' => 'Pressemeldungen',
                'slug' => 'pressemeldungen'
            ],
        ]);
        $press_photos_category = factory(App\Category::class)->create([
            'type' => 'presses',
            'en' => [
                'name' => 'Photos',
                'slug' => 'photos'
            ],
            'de' => [
                'name' => 'Fotos',
                'slug' => 'fotos'
            ],
        ]);
        $press_videos_category = factory(App\Category::class)->create([
            'type' => 'presses',
            'en' => [
                'name' => 'Videos',
                'slug' => 'videos'
            ],
            'de' => [
                'name' => 'Videos',
                'slug' => 'videos'
            ],
        ]);

        echo "finished press categories \n";

        foreach ($festivals as $festival) {
            $festival->translate('en')->attachFile($this->createFile('file')->id);
            $festival->translate('de')->attachFile($this->createFile('file')->id);

            factory(App\Press::class, 2)->create([
                'festival_id' => $festival->id,
                'gallery_id' => null,
                'category_id' => $press_videos_category->id
            ])->each(function($press) {
                $press->attachImage(factory(App\File::class)->create()->id);
            });

            echo "finished press video \n";

            factory(App\Press::class, 2)->create([
                'festival_id' => $festival->id,
                'type' => 'photo',
                'category_id' => $press_photos_category->id
            ])->each(function($press) {
                $gallery = factory(App\Gallery::class)->create();
                $gallery->images()->saveMany(factory(App\File::class, 3)->make());
                $press->gallery_id = $gallery->id;
                $press->save();
                $press->attachImage(factory(App\File::class)->create()->id);
            });

            echo "finished press photo \n";

             factory(App\Press::class, 2)->create([
                'festival_id' => $festival->id,
                'type' => 'press-release',
                'gallery_id' => null,
                'category_id' => $press_release_category->id
            ])->each(function($press) {
                $press->attachFile($this->createFile()->id);
            });

            echo "finished press-releases \n";

            $book = factory(App\Book::class)->create(['festival_id' => $festival->id]);
            $book->authors()->syncWithoutDetaching(factory(\App\Artist::class, 5)->create()->map->id->toArray());
            $book->attachImage(factory(App\File::class)->create()->id);

            echo "finished book \n";

            factory(App\Media::class, 4)->create(['festival_id' => $festival->id])
                ->each(function($media) {
                    $media->attachFile($this->createFile()->id);
                });

            echo "finished medias \n";

            foreach($partner_categories as $partner_category) {
                factory(App\Partner::class, 3)->create([
                    'category_id' => $partner_category->id,
                    'festival_id' => $festival->id
                ])
                ->each(function($partner) {
                    $partner->attachImage(factory(App\File::class)->create()->id);
                });
            }

            echo "finished partners \n";

            for ($i = 0; $i < 8; $i++) {
                factory(App\Post::class, 4)->create([
                    'category_id' => $news_categories[$i]->id,
                    'festival_id' => $festival->id,
                    'type' => 'news',
                    'gallery_id' => null,
                ])->each(function($post) {
                    $post->attachImage(factory(\App\File::class)->create()->id);

                    $gallery = factory(App\Gallery::class)->create();
                    $gallery->images()->saveMany(factory(App\File::class, 3)->make());
                    $post->gallery_id = $gallery->id;
                    $post->save();
                });

                echo "finished posts \n";

                $event = factory(App\Event::class, 4)->create([
                    'category_id' => $event_categories[$i]->id,
                    'festival_id' => $festival->id,
                    'promoting' => 0,
                    'gallery_id' => null
                ])
                ->each(function ($event) use ($places) {
                    $gallery = factory(App\Gallery::class)->create();
                    $gallery->images()->saveMany(factory(App\File::class, 3)->make());
                    $event->gallery_id = $gallery->id;
                    $event->save();

                    $event->attachImage(factory(\App\File::class)->create()->id);
                    $event->holdings()
                        ->saveMany(factory(App\EventHolding::class, 6)->make([
                            'place_id' => $places->random()->id,
                            'event_id' => null,
                        ]));

                    $event->persons()
                        ->syncWithoutDetaching([
                            rand(1, 50) => ['role' => 'director'],
                            rand(1, 50) => ['role' => 'artist'],
                            rand(1, 50) => ['role' => 'executive_producer'],
                            rand(1, 50) => ['role' => 'producer']
                        ]);
                });

                echo "finished events \n";
            }

            $event = factory(App\Event::class, 2)->create([
                    'category_id' => $event_categories->random()->id,
                    'festival_id' => $festival->id,
                    'promoting' => 1,
                    'gallery_id' => null
                ])
                ->each(function ($event) use ($places) {
                    $gallery = factory(App\Gallery::class)->create();
                    $gallery->images()->saveMany(factory(App\File::class, 3)->make());
                    $event->gallery_id = $gallery->id;
                    $event->save();

                    $event->attachImage(factory(\App\File::class)->create()->id);
                    $event->holdings()
                        ->saveMany(factory(App\EventHolding::class, 6)->make([
                            'place_id' => $places->random()->id,
                            'event_id' => null,
                        ]));

                    $event->persons()
                        ->syncWithoutDetaching([
                            rand(1, 50) => ['role' => 'director'],
                            rand(1, 50) => ['role' => 'artist'],
                            rand(1, 50) => ['role' => 'executive_producer'],
                            rand(1, 50) => ['role' => 'producer']
                        ]);
                });
            echo "finished promoting events \n";
        }

        echo "Finished with events and news \n";
    }

    protected function createFile($role = '')
    {
        $original_files = collect([
            '/app/test_files/file1.pdf',
            '/app/test_files/file2.pdf',
            '/app/test_files/file3.pdf',
            '/app/test_files/file4.pdf',
        ]);

        $today = today();
        $storage_path = storage_path();

        $original_file = new EloquentFile($storage_path . $original_files->random());
        $file_path = Storage::putFile('public/' . $today->year . '/' . $today->month, $original_file);
        $file_name = collect(explode('/', $file_path))->last();

        return File::create([
            'type' => 'doc',
            'path' => $file_path,
            'name' => $file_name,
            // 'role' => $role,
            'size' => round(filesize($storage_path . '/app/' . $file_path) / 1024, 0),
            'url'  => File::getFilePath($today) . $file_name
        ]);
    }
}
