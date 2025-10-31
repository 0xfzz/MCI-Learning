// Dashboard Search Configuration
const searchConfig = {
    // Common items for all users
    common: [
        {
            title: 'Dashboard',
            description: 'Halaman utama dashboard',
            icon: 'fa-gauge',
            type: 'Navigation',
            route: 'dashboard.index'
        },
        {
            title: 'Beranda',
            description: 'Kembali ke halaman utama',
            icon: 'fa-compass',
            type: 'Navigation',
            route: 'home'
        },
        {
            title: 'Edit Profil',
            description: 'Ubah informasi profil Anda',
            icon: 'fa-user',
            type: 'Settings',
            route: 'dashboard.profile.edit'
        },
        {
            title: 'Reset Password',
            description: 'Ubah password akun Anda',
            icon: 'fa-key',
            type: 'Settings',
            route: 'dashboard.profile.password.edit'
        },
        {
            title: 'Ubah Password',
            description: 'Ganti password untuk keamanan',
            icon: 'fa-key',
            type: 'Settings',
            route: 'dashboard.profile.password.edit'
        },
        {
            title: 'Pengaturan Profil',
            description: 'Kelola akun dan profil',
            icon: 'fa-user-circle',
            type: 'Settings',
            route: 'dashboard.profile.edit'
        },
        {
            title: 'Katalog Kursus',
            description: 'Jelajahi semua kursus tersedia',
            icon: 'fa-book',
            type: 'Courses',
            route: 'courses.index'
        },
        {
            title: 'Blog',
            description: 'Baca artikel dan tutorial',
            icon: 'fa-newspaper',
            type: 'Content',
            route: 'blog.index'
        },
        {
            title: 'Artikel',
            description: 'Baca artikel dan tutorial',
            icon: 'fa-newspaper',
            type: 'Content',
            route: 'blog.index'
        }
    ],

    // Admin specific items
    admin: [
        {
            title: 'Kelola Pengguna',
            description: 'Manajemen user dan role',
            icon: 'fa-users',
            type: 'Admin',
            route: 'dashboard.users.index'
        },
        {
            title: 'User Management',
            description: 'Kelola pengguna sistem',
            icon: 'fa-users',
            type: 'Admin',
            route: 'dashboard.users.index'
        },
        {
            title: 'Performa Penjualan',
            description: 'Lihat statistik dan laporan penjualan',
            icon: 'fa-chart-line',
            type: 'Admin',
            route: 'dashboard.sales.index'
        },
        {
            title: 'Laporan Penjualan',
            description: 'Analytics dan revenue',
            icon: 'fa-chart-line',
            type: 'Admin',
            route: 'dashboard.sales.index'
        },
        {
            title: 'Sales Report',
            description: 'Laporan penjualan kursus',
            icon: 'fa-chart-line',
            type: 'Admin',
            route: 'dashboard.sales.index'
        },
        {
            title: 'Verifikasi Transaksi',
            description: 'Verifikasi pembayaran kursus',
            icon: 'fa-clipboard-check',
            type: 'Admin',
            route: 'dashboard.transactions.index'
        },
        {
            title: 'Transaksi',
            description: 'Kelola pembayaran dan transaksi',
            icon: 'fa-clipboard-check',
            type: 'Admin',
            route: 'dashboard.transactions.index'
        },
        {
            title: 'Payment Verification',
            description: 'Verifikasi bukti transfer',
            icon: 'fa-clipboard-check',
            type: 'Admin',
            route: 'dashboard.transactions.index'
        },
        {
            title: 'Kelola Blog',
            description: 'Buat dan edit artikel blog',
            icon: 'fa-pen-nib',
            type: 'Admin',
            route: 'dashboard.blogs.index'
        },
        {
            title: 'Blog Management',
            description: 'Manajemen konten blog',
            icon: 'fa-pen-nib',
            type: 'Admin',
            route: 'dashboard.blogs.index'
        },
        {
            title: 'Artikel Blog',
            description: 'Kelola artikel dan konten',
            icon: 'fa-pen-nib',
            type: 'Admin',
            route: 'dashboard.blogs.index'
        }
    ],

    // Instructor specific items
    instructor: [
        {
            title: 'Kelola Kursus',
            description: 'Manajemen kursus yang Anda ajar',
            icon: 'fa-graduation-cap',
            type: 'Instructor',
            route: 'dashboard.courses.index'
        },
        {
            title: 'Course Management',
            description: 'Buat dan edit kursus',
            icon: 'fa-graduation-cap',
            type: 'Instructor',
            route: 'dashboard.courses.index'
        },
        {
            title: 'Kursus Saya',
            description: 'Daftar kursus yang Anda ajar',
            icon: 'fa-graduation-cap',
            type: 'Instructor',
            route: 'dashboard.courses.index'
        },
        {
            title: 'Buat Kursus',
            description: 'Tambah kursus baru',
            icon: 'fa-plus-circle',
            type: 'Instructor',
            route: 'dashboard.courses.create'
        },
        {
            title: 'Tambah Kursus',
            description: 'Create new course',
            icon: 'fa-plus-circle',
            type: 'Instructor',
            route: 'dashboard.courses.create'
        }
    ],

    // Student specific items
    student: [
        {
            title: 'Jelajahi Kursus',
            description: 'Lihat kursus yang sedang dipelajari',
            icon: 'fa-book-open',
            type: 'Student',
            route: 'dashboard.my-courses.index'
        },
        {
            title: 'Kursus Saya',
            description: 'Daftar kursus yang diikuti',
            icon: 'fa-book-open',
            type: 'Student',
            route: 'dashboard.my-courses.index'
        },
        {
            title: 'My Courses',
            description: 'Courses you are enrolled in',
            icon: 'fa-book-open',
            type: 'Student',
            route: 'dashboard.my-courses.index'
        },
        {
            title: 'Pembelajaran',
            description: 'Progress belajar Anda',
            icon: 'fa-book-open',
            type: 'Student',
            route: 'dashboard.my-courses.index'
        }
    ]
};

// Get search items based on user role
function getSearchItems(userRole) {
    let items = [...searchConfig.common];

    if (userRole === 'admin') {
        items = items.concat(searchConfig.admin);
    } else if (userRole === 'instructor') {
        items = items.concat(searchConfig.instructor);
    } else if (userRole === 'student') {
        items = items.concat(searchConfig.student);
    }

    return items;
}

// Search function
function searchItems(query, userRole, maxResults = 6) {
    if (!query || query.length < 2) {
        return [];
    }

    const items = getSearchItems(userRole);
    const searchQuery = query.toLowerCase();

    const results = items.filter(item =>
        item.title.toLowerCase().includes(searchQuery) ||
        item.description.toLowerCase().includes(searchQuery) ||
        item.type.toLowerCase().includes(searchQuery)
    );

    // Remove duplicates based on route
    const uniqueResults = results.filter((item, index, self) =>
        index === self.findIndex((t) => t.route === item.route)
    );

    return uniqueResults.slice(0, maxResults);
}

// Export for use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { searchConfig, getSearchItems, searchItems };
}
