<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display the admin user management overview.
     */
    public function index(Request $request)
    {
        $totalUsers = User::count();

        $metrics = $this->buildMetrics($totalUsers);
        $users = $this->fetchUsers($request);
        $availableRoles = $this->availableRoles();

        return view('admin.users', compact(
            'metrics',
            'users',
            'availableRoles'
        ));
    }

    /**
     * Update the role for a specific user.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(array_keys($this->availableRoles()))],
        ]);

        if ($user->user_id === $request->user()->user_id) {
            return back()->withErrors('Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        if ($user->role === 'admin' && $validated['role'] !== 'admin') {
            $remainingAdmins = User::where('role', 'admin')->where('user_id', '<>', $user->user_id)->count();
            if ($remainingAdmins === 0) {
                return back()->withErrors('Minimal satu admin harus tetap ada.');
            }
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('status', sprintf('Peran %s diperbarui menjadi %s.', $user->username, ucfirst($validated['role'])));
    }

    /**
     * Remove a user account from the system.
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->user_id === $request->user()->user_id) {
            return back()->withErrors('Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors('Minimal satu admin harus tetap ada.');
        }

        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus.');
    }

    private function buildMetrics(int $totalUsers): array
    {
        $now = now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $previousMonthStart = $now->copy()->subMonth()->startOfMonth();
        $previousMonthEnd = $now->copy()->subMonth()->endOfMonth();

        $newUsersThisMonth = User::where('created_at', '>=', $currentMonthStart)->count();
        $newUsersLastMonth = User::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();

        $instructorsTotal = User::where('role', 'instructor')->count();
        $instructorsThisMonth = User::where('role', 'instructor')
            ->where('created_at', '>=', $currentMonthStart)
            ->count();
        $instructorsLastMonth = User::where('role', 'instructor')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        $premiumTotal = Payment::success()->distinct('user_id')->count('user_id');
        $premiumThisMonth = Payment::success()
            ->where('created_at', '>=', $currentMonthStart)
            ->distinct('user_id')
            ->count('user_id');
        $premiumLastMonth = Payment::success()
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->distinct('user_id')
            ->count('user_id');

        return [
            [
                'label' => 'Total Pengguna',
                'value' => $this->formatNumber($totalUsers),
                'trend' => $this->formatChange($newUsersThisMonth, $newUsersLastMonth),
                'caption' => 'pendaftaran baru bulan ini',
                'gradient' => 'linear-gradient(135deg,#14b8a6,#0d9488)',
            ],
            [
                'label' => 'Instruktur Aktif',
                'value' => $this->formatNumber($instructorsTotal),
                'trend' => $this->formatChange($instructorsThisMonth, $instructorsLastMonth),
                'caption' => 'instruktur bergabung bulan ini',
                'gradient' => 'linear-gradient(135deg,#6366f1,#4338ca)',
            ],
            [
                'label' => 'Mahasiswa Premium',
                'value' => $this->formatNumber($premiumTotal),
                'trend' => $this->formatChange($premiumThisMonth, $premiumLastMonth),
                'caption' => 'pengguna upgrade bulan ini',
                'gradient' => 'linear-gradient(135deg,#f97316,#ea580c)',
            ],
        ];
    }

    private function fetchUsers(Request $request)
    {
        $search = $request->query('q');

        $query = User::query()
            ->select(['user_id', 'username', 'name', 'email', 'role', 'created_at'])
            ->orderByDesc('created_at');

        if ($search) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate(10)->withQueryString();
    }

    private function formatNumber(int $value): string
    {
        return number_format($value, 0, ',', '.');
    }

    private function formatChange(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '+100%' : '0%';
        }

        $change = (($current - $previous) / $previous) * 100;

        return sprintf('%s%.1f%%', $change >= 0 ? '+' : '-', abs($change));
    }

    private function availableRoles(): array
    {
        return [
            'admin' => 'Admin',
            'instructor' => 'Instructor',
            'student' => 'Student',
        ];
    }
}
