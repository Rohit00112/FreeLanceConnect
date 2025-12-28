<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancerDashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\clientfreelancerController;
use App\Http\Controllers\ClientFreelancerProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\PostProjectController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TaskController;


// Open Routes
Route::get('/', function () {return view('welcome');})->name('welcome');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

// Auth Routes
Route::middleware('auth')->group(function () {
     Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

     Route::middleware('role:admin,freelancer')->group(function () {
          Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
          Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
          Route::put('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.update-image');
     });

     Route::middleware('role:admin')->group(function () {
          Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
          Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

          Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
          Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
          Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
          Route::put('/admin/users/{user}/edit', [UserController::class, 'update'])->name('admin.users.update');
          Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
          Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
          Route::prefix('admin')->group(function () {
            Route::resource('team', TeamMemberController::class)->names([
                'index' => 'admin.team.index',
                'create' => 'admin.team.create',
                'store' => 'admin.team.store',
                'show' => 'admin.team.show',
                'edit' => 'admin.team.edit',
                'update' => 'admin.team.update',
                'destroy' => 'admin.team.destroy',
            ]);



});

     });

     Route::middleware('role:freelancer')->group(function () {
          Route::get('/freelancer/dashboard', [FreelancerDashboardController::class, 'index'])->name('freelancer.dashboard');
          Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
          Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
          Route::post('/projects', [ProjectController::class, 'store'])->name('project.store');
          Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
          Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
          Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

          Route::get('/clientprojects', [clientController::class, 'index'])->name('freelancer.projects');
          Route::post('/clientprojects/{id}/accept', [clientController::class, 'accept'])->name('freelancer.projects.accept');
          Route::post('/clientprojects/{id}/reject', [clientController::class, 'reject'])->name('freelancer.projects.reject');
          Route::delete('/{id}', [clientController::class, 'delete'])->name('freelancer.projects.delete');
          Route::get('/freelancer/todo', [TaskController::class, 'index'])->name('freelancer.todolist');

    // Add these routes for the CRUD operations
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
     });

     Route::middleware('role:client')->group(function () {
          Route::get('client/dashboard', [ClientDashboardController::class, 'index'])->name('clients.dashboard');
          Route::get('client/freelancers', [ClientFreelancerController::class, 'index'])->name('clients.freelancers.index');
          Route::get('/recommend-freelancers', [ClientFreelancerController::class, 'recommendFreelancers'])->name('recommend.freelancers');

          Route::get('client/freelancer/profile/{id}', [ClientFreelancerProfileController::class, 'show'])->name('clients.freelancer.profile');
          Route::get('client/post-projects', [PostProjectController::class, 'index'])->name('clients.post-projects');
          Route::get('client/post-projects/{id}/show', [PostProjectController::class, 'show'])->name('clients.post-projects.show');
          Route::get('client/post-project/{user}/create', [PostProjectController::class, 'create'])->name('clients.post-project.create');
          Route::post('client/post-project', [PostProjectController::class, 'store'])->name('clients.post-project.store');
          Route::get('client/profile/edit', [ClientProfileController::class, 'edit'])->name('clients.profile.edit');
          Route::put('client/profile/update', [ClientProfileController::class, 'update'])->name('clients.profile.update');
          Route::post('client/{freelancer}/review', [RatingController::class, 'reviewFreelancer'])->name('clients.review.freelancer');


          Route::post('client/payment/pre-payment-validation', [PaymentController::class, 'prePaymentValidation'])->name('clients.payment.pre-payment-validation');
          Route::post('client/payment/{postProjectId}/fulfill-order', [PaymentController::class, 'fulfillOrder'])->name('clients.payment.fulfillOrder');
          Route::get('paypal/payment/success', [PaymentController::class, 'paymentSuccess'])->name('clients.payment.success');
          Route::get('paypal/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('clients.payment.cancel');
          Route::get('/client/transactions', [ClientController::class, 'showTransactions'])->name('client.transactions');
     });
});
// Sanjeev





Route::get('/messages', function () {
    return view('messages'); // Return the messages view
})->name('messages.index');

// If you want to handle form submission without a controller
Route::post('/messages', function (Illuminate\Http\Request $request) {
    // Here you can handle the message submission
    // For now, just redirect back with a success message
    return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
})->name('messages.store');









Route::middleware('auth')->group(function () {
    // Freelancer's Chat Interface (Freelancer side)
    Route::get('/freelancer/chat/{otherUserId?}', [ChatController::class, 'freelancerChat'])->name('freelancer.chat');

    // Routes for fetching messages and sending messages
    Route::get('/chat/fetch/{otherUserId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/delete/{messageId}', [ChatController::class, 'delete'])->name('chat.delete');
});



// Route for client profile edit

// Route for client profile update (submit the form)
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/about',[AboutController::class, 'index'])->name('about');

Route::get('/messages', [ChatController::class, 'freelancerChat'])->name('Messages');

Route::middleware('auth')->group(function () {
    // Show chat interface with a specific user (pass the other user ID)
    Route::get('/chat/{otherUserId}', [ChatController::class, 'index'])->name('chat.index');

    // AJAX route to fetch messages (optional, if you want polling)
    Route::get('/chat/fetch/{otherUserId}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');

    // AJAX route to send a new message
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/delete/{messageId}', [ChatController::class, 'delete'])->name('chat.delete');


});

// Also Admin ?
Route::get('/dashboard/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/{id}', [ClientController::class, 'showProfile'])->name('clients.profile');

Route::get('/dashboard/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/dashboard/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/dashboard/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/dashboard/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/dashboard/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/dashboard/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

Route::post('/dashboard/clients/{client}/notes', [ClientController::class, 'addNote'])->name('clients.addNote');




Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




});

Route::middleware(['auth'])->group(function () {
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    // Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::post('clients/{client}/add-note', [NoteController::class, 'store'])->name('clients.addNote');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});


require __DIR__.'/auth.php';Route::middleware('role:freelancer')->group(function () {

});
