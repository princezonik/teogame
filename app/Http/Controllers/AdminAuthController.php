<!-- <?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class AdminAuthController extends Controller
{
    // Show admin login form
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Ensure you have the correct view file
    }

    // Handle admin login request
    public function login(Request $request)
    {
        // Validate the login form input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt to login
        if (Auth::attempt($validated)) {
            // Check if the user is an admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'You do not have admin privileges.']);
            }

            // Redirect to the admin dashboard
            return redirect()->route('admin.dashboard');
        }
    }

    public function dashboard()
{
    return view('admin.dashboard');
}

public function logout(Request $request)
{
    Auth::logout();

    // Invalidate the session and regenerate CSRF token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.logout')->with('status', 'Logged out successfully.');
}
} -->
