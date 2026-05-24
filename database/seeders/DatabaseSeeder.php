<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exhibition;
use App\Models\Artwork;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lumina.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $artist = User::create([
            'name' => 'Alex Chen',
            'email' => 'artist@lumina.com',
            'password' => Hash::make('password'),
            'role' => 'artist',
            'bio' => 'Digital artist exploring neon landscapes.',
        ]);

        $visitor = User::create([
            'name' => 'Test Visitor',
            'email' => 'visitor@lumina.com',
            'password' => Hash::make('password'),
            'role' => 'visitor',
        ]);

        // Exhibitions
        $exh1 = Exhibition::create([
            'user_id' => $artist->id,
            'title' => 'Neon Perspectives',
            'description' => 'A deep dive into cyber-aesthetic visuals and retro-futurism. Experience the glowing cityscape like never before.',
            'status' => 'active',
            'is_featured' => true,
            'views' => 1250,
        ]);

        $exh2 = Exhibition::create([
            'user_id' => $artist->id,
            'title' => 'Echoes of Silence',
            'description' => 'Minimalist monochrome captures of vast emptiness. A peaceful journey into nothingness.',
            'status' => 'active',
            'is_featured' => true,
            'views' => 890,
        ]);

        $exh3 = Exhibition::create([
            'user_id' => $artist->id,
            'title' => 'Digital Flora',
            'description' => 'A botanical garden simulated in high-definition virtual reality. Unnatural beauty.',
            'status' => 'active',
            'is_featured' => true,
            'views' => 310,
        ]);

        // Artworks - Exhibition 1 (Neon Perspectives) - 6 artworks
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 400, 'title' => 'Neon Dreams', 'description' => 'The start of the neon era.', 'image_path' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 650, 'title' => 'Cyber CPU', 'description' => 'The core processor of the digital metropolis.', 'image_path' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 150, 'title' => 'Grid Runner', 'description' => 'Speeding through the neon grid.', 'image_path' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 200, 'title' => 'Synthwave Skyline', 'description' => 'A beautiful sunset over the digital city.', 'image_path' => 'https://images.unsplash.com/photo-1563089145-599997674d42?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 180, 'title' => 'Cyber Alley', 'description' => 'Dark alleys illuminated by neon signs.', 'image_path' => 'https://images.unsplash.com/photo-1515462277126-2dd0c162007a?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh1->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 220, 'title' => 'Holographic Memories', 'description' => 'Data structures forming physical shapes.', 'image_path' => 'https://images.unsplash.com/photo-1558486012-817176f84c6d?w=800&q=80']);

        // Artworks - Exhibition 2 (Echoes of Silence) - 6 artworks
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 200, 'title' => 'Silent Whisper', 'description' => 'Abstract thoughts forming in silence.', 'image_path' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 320, 'title' => 'Void Star', 'description' => 'A single point of light in the infinite void.', 'image_path' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 140, 'title' => 'Monochrome Lake', 'description' => 'A perfectly still body of water.', 'image_path' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 90, 'title' => 'Distant Mountain', 'description' => 'Fog obscuring the peak.', 'image_path' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 110, 'title' => 'Solitude', 'description' => 'One tree standing alone.', 'image_path' => 'https://images.unsplash.com/photo-1476820865390-c52aeebb9891?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh2->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 210, 'title' => 'Empty Path', 'description' => 'A road leading to nowhere.', 'image_path' => 'https://images.unsplash.com/photo-1444084316824-dc26d6657664?w=800&q=80']);

        // Artworks - Exhibition 3 (Digital Flora) - 6 artworks
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 110, 'title' => 'Fractal Fern', 'description' => 'Mathematically generated botanical life.', 'image_path' => 'https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 450, 'title' => 'Crystal Petals', 'description' => 'Flowers that shatter on impact.', 'image_path' => 'https://images.unsplash.com/photo-1520013094852-78d2ccb3687c?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 220, 'title' => 'Binary Blossom', 'description' => 'A flower blooming in zeroes and ones.', 'image_path' => 'https://images.unsplash.com/photo-1490750967868-88ce4e4ebc7f?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 190, 'title' => 'Neon Vines', 'description' => 'Glowing flora overtaking the system.', 'image_path' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 130, 'title' => 'Glass Leaves', 'description' => 'Fragile digital foliage.', 'image_path' => 'https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?w=800&q=80']);
        Artwork::create(['exhibition_id' => $exh3->id, 'user_id' => $artist->id, 'artist_name' => 'Alex Chen', 'views' => 270, 'title' => 'Synthetic Roots', 'description' => 'The foundation of the digital forest.', 'image_path' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?w=800&q=80']);

        // Generate mock Engagement (Likes & Comments) over the last 7 days so charts aren't empty
        $allArtworks = Artwork::all();
        $sampleComments = ['Amazing work!', 'Love the composition.', 'Stunning detail!', 'Absolutely beautiful.', 'Incredible color palette.', 'This speaks to me.'];
        $userIds = [$admin->id, $artist->id, $visitor->id];

        foreach ($allArtworks as $art) {
            $numLikers = rand(1, 3);
            $shuffledUsers = $userIds;
            shuffle($shuffledUsers);
            $likers = array_slice($shuffledUsers, 0, $numLikers);

            foreach ($likers as $uid) {
                $randomDate = \Carbon\Carbon::now()->subDays(rand(0, 6));
                
                \App\Models\Like::create([
                    'user_id' => $uid,
                    'likeable_id' => $art->id,
                    'likeable_type' => \App\Models\Artwork::class,
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate
                ]);

                if (rand(1, 100) > 40) { // 60% chance to also leave a comment
                    \App\Models\Comment::create([
                        'user_id' => $uid,
                        'artwork_id' => $art->id,
                        'body' => $sampleComments[array_rand($sampleComments)],
                        'created_at' => $randomDate,
                        'updated_at' => $randomDate
                    ]);
                }
            }
        }

        // Add Registrations
        \App\Models\Registration::create(['user_id' => $visitor->id, 'exhibition_id' => $exh1->id]);
        \App\Models\Registration::create(['user_id' => $visitor->id, 'exhibition_id' => $exh2->id]);
    }
}
