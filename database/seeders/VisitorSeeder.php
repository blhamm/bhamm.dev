<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visitors = [
            ['ip_address' => '69.162.81.155', 'city' => 'New York', 'state' => 'NY', 'country' => 'US', 'latitude' => 40.7128, 'longitude' => -74.0060],
            ['ip_address' => '104.236.176.100', 'city' => 'Los Angeles', 'state' => 'CA', 'country' => 'US', 'latitude' => 34.0522, 'longitude' => -118.2437],
            ['ip_address' => '45.55.128.100', 'city' => 'Chicago', 'state' => 'IL', 'country' => 'US', 'latitude' => 41.8781, 'longitude' => -87.6298],
            ['ip_address' => '192.185.16.100', 'city' => 'Houston', 'state' => 'TX', 'country' => 'US', 'latitude' => 29.7604, 'longitude' => -95.3698],
            ['ip_address' => '66.240.205.100', 'city' => 'Phoenix', 'state' => 'AZ', 'country' => 'US', 'latitude' => 33.4484, 'longitude' => -112.0740],
            ['ip_address' => '173.255.240.100', 'city' => 'Philadelphia', 'state' => 'PA', 'country' => 'US', 'latitude' => 39.9526, 'longitude' => -75.1652],
            ['ip_address' => '67.222.152.100', 'city' => 'San Antonio', 'state' => 'TX', 'country' => 'US', 'latitude' => 29.4241, 'longitude' => -98.4936],
            ['ip_address' => '192.169.145.100', 'city' => 'San Diego', 'state' => 'CA', 'country' => 'US', 'latitude' => 32.7157, 'longitude' => -117.1611],
            ['ip_address' => '108.167.140.100', 'city' => 'Dallas', 'state' => 'TX', 'country' => 'US', 'latitude' => 32.7767, 'longitude' => -96.7970],
            ['ip_address' => '199.115.116.100', 'city' => 'San Jose', 'state' => 'CA', 'country' => 'US', 'latitude' => 37.3382, 'longitude' => -121.8863],
            ['ip_address' => '162.243.150.100', 'city' => 'Austin', 'state' => 'TX', 'country' => 'US', 'latitude' => 30.2672, 'longitude' => -97.7431],
            ['ip_address' => '64.91.240.100', 'city' => 'Jacksonville', 'state' => 'FL', 'country' => 'US', 'latitude' => 30.3322, 'longitude' => -81.6557],
            ['ip_address' => '208.113.200.100', 'city' => 'Fort Worth', 'state' => 'TX', 'country' => 'US', 'latitude' => 32.7555, 'longitude' => -97.3308],
            ['ip_address' => '74.208.150.100', 'city' => 'Columbus', 'state' => 'OH', 'country' => 'US', 'latitude' => 39.9612, 'longitude' => -82.9988],
            ['ip_address' => '50.116.50.100', 'city' => 'Charlotte', 'state' => 'NC', 'country' => 'US', 'latitude' => 35.2271, 'longitude' => -80.8431],
            ['ip_address' => '104.236.1.100', 'city' => 'San Francisco', 'state' => 'CA', 'country' => 'US', 'latitude' => 37.7749, 'longitude' => -122.4194],
            ['ip_address' => '108.61.180.100', 'city' => 'Indianapolis', 'state' => 'IN', 'country' => 'US', 'latitude' => 39.7684, 'longitude' => -86.1581],
            ['ip_address' => '159.203.240.100', 'city' => 'Seattle', 'state' => 'WA', 'country' => 'US', 'latitude' => 47.6062, 'longitude' => -122.3321],
            ['ip_address' => '162.216.16.100', 'city' => 'Denver', 'state' => 'CO', 'country' => 'US', 'latitude' => 39.7392, 'longitude' => -104.9903],
            ['ip_address' => '204.93.150.100', 'city' => 'Washington', 'state' => 'DC', 'country' => 'US', 'latitude' => 38.9072, 'longitude' => -77.0369],
            ['ip_address' => '192.155.200.100', 'city' => 'Boston', 'state' => 'MA', 'country' => 'US', 'latitude' => 42.3601, 'longitude' => -71.0589],
            ['ip_address' => '23.235.200.100', 'city' => 'El Paso', 'state' => 'TX', 'country' => 'US', 'latitude' => 31.7619, 'longitude' => -106.4850],
            ['ip_address' => '69.195.120.100', 'city' => 'Nashville', 'state' => 'TN', 'country' => 'US', 'latitude' => 36.1627, 'longitude' => -86.7816],
            ['ip_address' => '67.227.200.100', 'city' => 'Detroit', 'state' => 'MI', 'country' => 'US', 'latitude' => 42.3314, 'longitude' => -83.0458],
            ['ip_address' => '64.29.150.100', 'city' => 'Oklahoma City', 'state' => 'OK', 'country' => 'US', 'latitude' => 35.4676, 'longitude' => -97.5164],
            ['ip_address' => '192.241.160.100', 'city' => 'Portland', 'state' => 'OR', 'country' => 'US', 'latitude' => 45.5152, 'longitude' => -122.6784],
            ['ip_address' => '209.126.100.100', 'city' => 'Las Vegas', 'state' => 'NV', 'country' => 'US', 'latitude' => 36.1699, 'longitude' => -115.1398],
            ['ip_address' => '69.167.150.100', 'city' => 'Memphis', 'state' => 'TN', 'country' => 'US', 'latitude' => 35.1495, 'longitude' => -90.0490],
            ['ip_address' => '74.208.200.100', 'city' => 'Louisville', 'state' => 'KY', 'country' => 'US', 'latitude' => 38.2527, 'longitude' => -85.7585],
            ['ip_address' => '173.255.200.100', 'city' => 'Baltimore', 'state' => 'MD', 'country' => 'US', 'latitude' => 39.2904, 'longitude' => -76.6122],
            ['ip_address' => '66.96.150.100', 'city' => 'Milwaukee', 'state' => 'WI', 'country' => 'US', 'latitude' => 43.0389, 'longitude' => -87.9065],
            ['ip_address' => '67.222.200.100', 'city' => 'Albuquerque', 'state' => 'NM', 'country' => 'US', 'latitude' => 35.0844, 'longitude' => -106.6504],
            ['ip_address' => '64.91.200.100', 'city' => 'Tucson', 'state' => 'AZ', 'country' => 'US', 'latitude' => 32.2226, 'longitude' => -110.9747],
            ['ip_address' => '192.169.200.100', 'city' => 'Fresno', 'state' => 'CA', 'country' => 'US', 'latitude' => 36.7378, 'longitude' => -119.7871],
            ['ip_address' => '108.167.200.100', 'city' => 'Sacramento', 'state' => 'CA', 'country' => 'US', 'latitude' => 38.5816, 'longitude' => -121.4944],
            ['ip_address' => '199.115.200.100', 'city' => 'Kansas City', 'state' => 'MO', 'country' => 'US', 'latitude' => 39.0997, 'longitude' => -94.5786],
            ['ip_address' => '162.243.200.100', 'city' => 'Long Beach', 'state' => 'CA', 'country' => 'US', 'latitude' => 33.7701, 'longitude' => -118.1937],
            ['ip_address' => '64.29.200.100', 'city' => 'Mesa', 'state' => 'AZ', 'country' => 'US', 'latitude' => 33.4151, 'longitude' => -111.8315],
            ['ip_address' => '107.170.240.100', 'city' => 'Atlanta', 'state' => 'GA', 'country' => 'US', 'latitude' => 33.7490, 'longitude' => -84.3880],
            ['ip_address' => '45.33.50.100', 'city' => 'Colorado Springs', 'state' => 'CO', 'country' => 'US', 'latitude' => 38.8339, 'longitude' => -104.8214],
            ['ip_address' => '212.58.244.70', 'city' => 'London', 'state' => 'ENG', 'country' => 'GB', 'latitude' => 51.5074, 'longitude' => -0.1278],
            ['ip_address' => '89.238.150.100', 'city' => 'Manchester', 'state' => 'ENG', 'country' => 'GB', 'latitude' => 53.4808, 'longitude' => -2.2426],
            ['ip_address' => '185.151.150.100', 'city' => 'Birmingham', 'state' => 'ENG', 'country' => 'GB', 'latitude' => 52.4862, 'longitude' => -1.8904],
            ['ip_address' => '79.170.150.100', 'city' => 'Glasgow', 'state' => 'SCT', 'country' => 'GB', 'latitude' => 55.8642, 'longitude' => -4.2518],
            ['ip_address' => '193.105.150.100', 'city' => 'Edinburgh', 'state' => 'SCT', 'country' => 'GB', 'latitude' => 55.9533, 'longitude' => -3.1883],
            ['ip_address' => '176.31.224.234', 'city' => 'Paris', 'state' => 'IDF', 'country' => 'FR', 'latitude' => 48.8566, 'longitude' => 2.3522],
            ['ip_address' => '91.121.150.100', 'city' => 'Lyon', 'state' => 'ARA', 'country' => 'FR', 'latitude' => 45.7640, 'longitude' => 4.8357],
            ['ip_address' => '188.165.150.100', 'city' => 'Marseille', 'state' => 'PAC', 'country' => 'FR', 'latitude' => 43.2965, 'longitude' => 5.3698],
            ['ip_address' => '5.9.158.75', 'city' => 'Berlin', 'state' => 'BE', 'country' => 'DE', 'latitude' => 52.5200, 'longitude' => 13.4050],
            ['ip_address' => '78.46.150.100', 'city' => 'Munich', 'state' => 'BY', 'country' => 'DE', 'latitude' => 48.1351, 'longitude' => 11.5820],
            ['ip_address' => '88.198.150.100', 'city' => 'Hamburg', 'state' => 'HH', 'country' => 'DE', 'latitude' => 53.5511, 'longitude' => 9.9937],
            ['ip_address' => '144.76.150.100', 'city' => 'Frankfurt', 'state' => 'HE', 'country' => 'DE', 'latitude' => 50.1109, 'longitude' => 8.6821],
            ['ip_address' => '202.214.194.147', 'city' => 'Tokyo', 'state' => '13', 'country' => 'JP', 'latitude' => 35.6895, 'longitude' => 139.6917],
            ['ip_address' => '210.140.150.100', 'city' => 'Osaka', 'state' => '27', 'country' => 'JP', 'latitude' => 34.6937, 'longitude' => 135.5023],
            ['ip_address' => '153.120.150.100', 'city' => 'Nagoya', 'state' => '23', 'country' => 'JP', 'latitude' => 35.1815, 'longitude' => 136.9066],
            ['ip_address' => '1.1.1.1', 'city' => 'Sydney', 'state' => 'NSW', 'country' => 'AU', 'latitude' => -33.8688, 'longitude' => 151.2093],
            ['ip_address' => '103.25.150.100', 'city' => 'Melbourne', 'state' => 'VIC', 'country' => 'AU', 'latitude' => -37.8136, 'longitude' => 144.9631],
            ['ip_address' => '203.0.178.100', 'city' => 'Brisbane', 'state' => 'QLD', 'country' => 'AU', 'latitude' => -27.4698, 'longitude' => 153.0251],
            ['ip_address' => '27.50.150.100', 'city' => 'Perth', 'state' => 'WA', 'country' => 'AU', 'latitude' => -31.9505, 'longitude' => 115.8605],
            ['ip_address' => '159.203.50.100', 'city' => 'Toronto', 'state' => 'ON', 'country' => 'CA', 'latitude' => 43.6532, 'longitude' => -79.3832],
            ['ip_address' => '192.241.200.100', 'city' => 'Vancouver', 'state' => 'BC', 'country' => 'CA', 'latitude' => 49.2827, 'longitude' => -123.1207],
            ['ip_address' => '198.27.150.100', 'city' => 'Montreal', 'state' => 'QC', 'country' => 'CA', 'latitude' => 45.5017, 'longitude' => -73.5673],
            ['ip_address' => '177.71.150.100', 'city' => 'Sao Paulo', 'state' => 'SP', 'country' => 'BR', 'latitude' => -23.5505, 'longitude' => -46.6333],
            ['ip_address' => '200.155.150.100', 'city' => 'Rio de Janeiro', 'state' => 'RJ', 'country' => 'BR', 'latitude' => -22.9068, 'longitude' => -43.1729],
            ['ip_address' => '103.21.150.100', 'city' => 'Mumbai', 'state' => 'MH', 'country' => 'IN', 'latitude' => 19.0760, 'longitude' => 72.8777],
            ['ip_address' => '125.16.150.100', 'city' => 'New Delhi', 'state' => 'DL', 'country' => 'IN', 'latitude' => 28.6139, 'longitude' => 77.2090],
            ['ip_address' => '49.207.150.100', 'city' => 'Bangalore', 'state' => 'KA', 'country' => 'IN', 'latitude' => 12.9716, 'longitude' => 77.5946],
            ['ip_address' => '197.242.150.100', 'city' => 'Cape Town', 'state' => 'WC', 'country' => 'ZA', 'latitude' => -33.9249, 'longitude' => 18.4241],
            ['ip_address' => '196.35.150.100', 'city' => 'Johannesburg', 'state' => 'GP', 'country' => 'ZA', 'latitude' => -26.2041, 'longitude' => 28.0473],
            ['ip_address' => '128.199.150.100', 'city' => 'Singapore', 'state' => null, 'country' => 'SG', 'latitude' => 1.3521, 'longitude' => 103.8198],
            ['ip_address' => '103.16.150.100', 'city' => 'Hong Kong', 'state' => null, 'country' => 'HK', 'latitude' => 22.3193, 'longitude' => 114.1694],
            ['ip_address' => '211.249.150.100', 'city' => 'Seoul', 'state' => '11', 'country' => 'KR', 'latitude' => 37.5665, 'longitude' => 126.9780],
            ['ip_address' => '203.151.150.100', 'city' => 'Bangkok', 'state' => '10', 'country' => 'TH', 'latitude' => 13.7563, 'longitude' => 100.5018],
            ['ip_address' => '103.28.150.100', 'city' => 'Jakarta', 'state' => 'JK', 'country' => 'ID', 'latitude' => -6.2088, 'longitude' => 106.8456],
            ['ip_address' => '124.106.150.100', 'city' => 'Manila', 'state' => '00', 'country' => 'PH', 'latitude' => 14.5995, 'longitude' => 120.9842],
            ['ip_address' => '118.69.150.100', 'city' => 'Ho Chi Minh City', 'state' => 'SG', 'country' => 'VN', 'latitude' => 10.8231, 'longitude' => 106.6297],
            ['ip_address' => '210.187.150.100', 'city' => 'Kuala Lumpur', 'state' => '14', 'country' => 'MY', 'latitude' => 3.1390, 'longitude' => 101.6869],
            ['ip_address' => '188.166.150.100', 'city' => 'Amsterdam', 'state' => 'NH', 'country' => 'NL', 'latitude' => 52.3676, 'longitude' => 4.9041],
            ['ip_address' => '88.26.150.100', 'city' => 'Madrid', 'state' => 'MD', 'country' => 'ES', 'latitude' => 40.4168, 'longitude' => -3.7038],
            ['ip_address' => '80.24.150.100', 'city' => 'Barcelona', 'state' => 'CT', 'country' => 'ES', 'latitude' => 41.3851, 'longitude' => 2.1734],
            ['ip_address' => '2.228.150.100', 'city' => 'Rome', 'state' => '62', 'country' => 'IT', 'latitude' => 41.9028, 'longitude' => 12.4964],
            ['ip_address' => '151.0.150.100', 'city' => 'Milan', 'state' => '25', 'country' => 'IT', 'latitude' => 45.4642, 'longitude' => 9.1900],
            ['ip_address' => '194.103.150.100', 'city' => 'Stockholm', 'state' => 'AB', 'country' => 'SE', 'latitude' => 59.3293, 'longitude' => 18.0686],
            ['ip_address' => '158.38.150.100', 'city' => 'Oslo', 'state' => '03', 'country' => 'NO', 'latitude' => 59.9139, 'longitude' => 10.7522],
            ['ip_address' => '130.225.150.100', 'city' => 'Copenhagen', 'state' => '84', 'country' => 'DK', 'latitude' => 55.6761, 'longitude' => 12.5683],
            ['ip_address' => '128.214.150.100', 'city' => 'Helsinki', 'state' => '18', 'country' => 'FI', 'latitude' => 60.1699, 'longitude' => 24.9384],
            ['ip_address' => '89.101.150.100', 'city' => 'Dublin', 'state' => 'L', 'country' => 'IE', 'latitude' => 53.3498, 'longitude' => -6.2603],
            ['ip_address' => '213.13.150.100', 'city' => 'Lisbon', 'state' => '11', 'country' => 'PT', 'latitude' => 38.7223, 'longitude' => -9.1393],
            ['ip_address' => '193.170.150.100', 'city' => 'Vienna', 'state' => '09', 'country' => 'AT', 'latitude' => 48.2082, 'longitude' => 16.3738],
            ['ip_address' => '9.9.9.9', 'city' => 'Zurich', 'state' => 'ZH', 'country' => 'CH', 'latitude' => 47.3769, 'longitude' => 8.5417],
            ['ip_address' => '134.58.150.100', 'city' => 'Brussels', 'state' => 'BRU', 'country' => 'BE', 'latitude' => 50.8503, 'longitude' => 4.3517],
            ['ip_address' => '212.77.150.100', 'city' => 'Warsaw', 'state' => '78', 'country' => 'PL', 'latitude' => 52.2297, 'longitude' => 21.0122],
            ['ip_address' => '78.128.150.100', 'city' => 'Prague', 'state' => '52', 'country' => 'CZ', 'latitude' => 50.0755, 'longitude' => 14.4378],
            ['ip_address' => '195.199.150.100', 'city' => 'Budapest', 'state' => 'BU', 'country' => 'HU', 'latitude' => 47.4979, 'longitude' => 19.0402],
            ['ip_address' => '147.102.150.100', 'city' => 'Athens', 'state' => 'I', 'country' => 'GR', 'latitude' => 37.9838, 'longitude' => 23.7275],
            ['ip_address' => '212.156.150.100', 'city' => 'Istanbul', 'state' => '34', 'country' => 'TR', 'latitude' => 41.0082, 'longitude' => 28.9784],
            ['ip_address' => '94.200.150.100', 'city' => 'Dubai', 'state' => 'DU', 'country' => 'AE', 'latitude' => 25.2048, 'longitude' => 55.2708],
            ['ip_address' => '192.114.150.100', 'city' => 'Tel Aviv', 'state' => 'TA', 'country' => 'IL', 'latitude' => 32.0853, 'longitude' => 34.7818],
            ['ip_address' => '201.150.150.100', 'city' => 'Mexico City', 'state' => 'CMX', 'country' => 'MX', 'latitude' => 19.4326, 'longitude' => -99.1332],
            ['ip_address' => '181.30.150.100', 'city' => 'Buenos Aires', 'state' => 'B', 'country' => 'AR', 'latitude' => -34.6037, 'longitude' => -58.3816],
        ];

        foreach ($visitors as $visitor) {
            \App\Models\Visitor::create(array_merge($visitor, [
                'last_seen_at' => now()->subMinutes(rand(0, 10080)), // Last 7 days
            ]));
        }
    }
}
