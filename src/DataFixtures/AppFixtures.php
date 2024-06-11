<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use App\Entity\Cursus;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Themes with images and icons
        $themesData = [
            'Musique' => [
                'image' => 'musique.jpg',
                'icon' => 'https://img.icons8.com/?size=100&id=9LWBsHiDsA04&format=png&color=000000',
                'cursus' => [
                    [
                        'name' => 'Cursus d’initiation à la guitare',
                        'price' => 50,
                        'lessons' => [
                            ['name' => 'Découverte de l’instrument', 'price' => 26],
                            ['name' => 'Les accords et les gammes', 'price' => 26],
                        ],
                    ],
                    [
                        'name' => 'Cursus d’initiation au piano',
                        'price' => 50,
                        'lessons' => [
                            ['name' => 'Découverte de l’instrument', 'price' => 26],
                            ['name' => 'Les accords et les gammes', 'price' => 26],
                        ],
                    ],
                ],
            ],
            'Informatique' => [
                'image' => 'informatique.jpg',
                'icon' => 'https://img.icons8.com/?size=100&id=19800&format=png&color=000000',
                'cursus' => [
                    [
                        'name' => 'Cursus d’initiation au développement web',
                        'price' => 60,
                        'lessons' => [
                            ['name' => 'Les langages Html et CSS', 'price' => 32],
                            ['name' => 'Dynamiser votre site avec Javascript', 'price' => 32],
                        ],
                    ],
                ],
            ],
            'Jardinage' => [
                'image' => 'jardinage.jpg',
                'icon' => 'https://img.icons8.com/?size=100&id=OKMC0MrrQY5I&format=png&color=000000',
                'cursus' => [
                    [
                        'name' => 'Cursus d’initiation au jardinage',
                        'price' => 30,
                        'lessons' => [
                            ['name' => 'Les outils du jardinier', 'price' => 16],
                            ['name' => 'Jardiner avec la lune', 'price' => 16],
                        ],
                    ],
                ],
            ],
            'Cuisine' => [
                'image' => 'cuisine.jpg',
                'icon' => 'https://img.icons8.com/?size=100&id=G4tBuoihEhYG&format=png&color=000000',
                'cursus' => [
                    [
                        'name' => 'Cursus d’initiation à la cuisine',
                        'price' => 44,
                        'lessons' => [
                            ['name' => 'Les modes de cuisson', 'price' => 23],
                            ['name' => 'Les saveurs', 'price' => 23],
                        ],
                    ],
                    [
                        'name' => 'Cursus d’initiation à l’art du dressage culinaire',
                        'price' => 48,
                        'lessons' => [
                            ['name' => 'Mettre en œuvre le style dans l’assiette', 'price' => 26],
                            ['name' => 'Harmoniser un repas à quatre plats', 'price' => 26],
                        ],
                    ],
                ],
            ],
            // Add more themes here with their corresponding images and icons
        ];

        // Lesson video URLs
        $lessonVideoUrls = [
            // Music
            'https://www.youtube.com/watch?time_continue=2&v=uIO2CaSXbgQ&embeds_referring_euri=https%3A%2F%2Fwww.bing.com%2F&embeds_referring_origin=https%3A%2F%2Fwww.bing.com&source_ve_path=Mjg2NjY&feature=emb_logo', // Lesson 1: Guitar initiation course
            'https://www.youtube.com/watch?v=COKL-Av8Knk&embeds_referring_euri=https%3A%2F%2Fwww.bing.com%2F&embeds_referring_origin=https%3A%2F%2Fwww.bing.com&source_ve_path=Mjg2NjY&feature=emb_logo', // Lesson 2: Guitar initiation course
            'https://www.youtube.com/watch?v=5FVw6Yl2hpk', // Lesson 1: Piano initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Les+accords+et+les+gammes+du+piano&&mid=43E823CABE3FDC99D67F43E823CABE3FDC99D67F&&FORM=VRDGAR', // Lesson 2: Piano initiation course
            // IT
            'https://www.bing.com/videos/riverview/relatedvideo?&q=+Les+langages+Html+et+CSS&&mid=1F00302861F3D25078201F00302861F3D2507820&&FORM=VRDGAR', // Lesson 1: Web development initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Dynamiser+votre+site+avec+Javascript&&mid=FA945001518289EE3BB1FA945001518289EE3BB1&&FORM=VRDGAR', // Lesson 2: Web development initiation course
            // Gardening
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Les+outils+du+jardinier&&mid=FB52FA0008EAD3DA9973FB52FA0008EAD3DA9973&&FORM=VRDGAR', // Lesson 1: Gardening initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=+Jardiner+avec+la+lune&&mid=77E1AF2071A7E3C86D8A77E1AF2071A7E3C86D8A&&FORM=VRDGAR', // Lesson 2: Gardening initiation course
            // Cooking
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Les+modes+de+cuisson&&mid=CAEB30EE4BC50752DF8CCAEB30EE4BC50752DF8C&&FORM=VRDGAR', // Lesson 1: Cooking initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Les+saveurs+en+cuisine&&mid=0457D90DB245A61274B10457D90DB245A61274B1&&FORM=VRDGAR', // Lesson 2: Cooking initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Mettre+en+%c5%93uvre+le+style+dans+l%e2%80%99assiette&&mid=07FA9F564336F79120C707FA9F564336F79120C7&&FORM=VRDGAR', // Lesson 1: Culinary presentation initiation course
            'https://www.bing.com/videos/riverview/relatedvideo?&q=Harmoniser+un+repas+%c3%a0+quatre+plats&&mid=1A7CF659A4579F31ED3B1A7CF659A4579F31ED3B&&FORM=VRDGAR', // Lesson 2: Culinary presentation initiation course
        ];

        foreach ($themesData as $themeName => $themeData) {
            $theme = new Theme();
            $theme->setName($themeName);
            $theme->setImage($themeData['image']);
            $theme->setIcon($themeData['icon']);
            $manager->persist($theme);

            // Creating curriculums and lessons for this theme
            foreach ($themeData['cursus'] as $cursusData) {
                $cursus = new Cursus();
                $cursus->setName($cursusData['name']);
                $cursus->setPrice($cursusData['price']);
                $cursus->setTheme($theme);
                $manager->persist($cursus);

                foreach ($cursusData['lessons'] as $lessonData) {
                    $lesson = new Lesson();
                    $lesson->setName($lessonData['name']);
                    $lesson->setPrice($lessonData['price']);
                    $lesson->setCursus($cursus);
                    $numParagraphs = 10; // Number of Lorem Ipsum paragraphs per lesson
                    $loremIpsumText = $this->generateLoremIpsum($numParagraphs); // Using $this->generateLoremIpsum
                    $lesson->setDescription($loremIpsumText);
                    $lessonVideoUrl = array_shift($lessonVideoUrls); // Get the next YouTube video URL
                    $lesson->setYoutubeUrl($lessonVideoUrl);
                    $manager->persist($lesson);
                }
            }
        }

        $manager->flush();
    }

    // Generate Lorem Ipsum text with the specified number of paragraphs
    private function generateLoremIpsum(int $numParagraphs): string
    {
        $loremIpsumText = ''; // Initialize text
        for ($i = 0; $i < $numParagraphs; $i++) {
            $loremIpsumText .= 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '; // Add a Lorem Ipsum paragraph
        }
        return $loremIpsumText;
    }
}
