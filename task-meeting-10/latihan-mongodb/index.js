// Latihan NoSQL: menyimpan data pengguna dengan MongoDB
const { MongoClient } = require('mongodb');

// Koneksi ke database MongoDB
const uri = 'mongodb://localhost:27017';
const client = new MongoClient(uri);

async function run() {
    try {
        await client.connect();
        const database = client.db('userDB');
        const users = database.collection('users');

        // Kosongkan koleksi supaya hasilnya sama setiap kali dijalankan
        await users.deleteMany({});

        // Menambahkan data pengguna.
        // Tidak ada skema tetap, jadi setiap dokumen boleh punya field yang berbeda.
        await users.insertMany([
            { name: 'Dewi Lestari', email: 'dewi@example.com', age: 30 },
            {
                name: 'Budi Santoso',
                email: 'budi@example.com',
                age: 21,
                hobbies: ['membaca', 'futsal']
            },
            {
                name: 'Siti Aminah',
                email: 'siti@example.com',
                address: { city: 'Surabaya', province: 'Jawa Timur' },
                phone: '081234567890'
            }
        ]);

        // Mengambil semua data pengguna
        const allUsers = await users.find().toArray();
        console.log('Semua pengguna:');
        console.log(allUsers);

        // Mengambil pengguna yang berumur di atas 25 tahun
        const olderUsers = await users.find({ age: { $gt: 25 } }).toArray();
        console.log('Pengguna berumur di atas 25 tahun:');
        console.log(olderUsers);

        // Mengubah data: menambahkan field baru pada satu pengguna
        await users.updateOne({ name: 'Dewi Lestari' }, { $set: { job: 'Web Developer' } });
        const dewi = await users.findOne({ name: 'Dewi Lestari' });
        console.log('Dewi Lestari setelah ditambah field job:');
        console.log(dewi);
    } finally {
        await client.close();
    }
}

run().catch(console.error);
