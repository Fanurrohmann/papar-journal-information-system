<?php

use App\Http\Controllers\Admin\AdminAdvertisementController;
use App\Http\Controllers\Admin\AdminAuthorController;
use App\Http\Controllers\Admin\AdminEditorController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminFaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminLanguageController;
use App\Http\Controllers\Admin\AdminLiveChannelController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminOnlinePollController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPhotoController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminSocialItemController;
use App\Http\Controllers\Admin\AdminSubCategoryController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\Author\AuthorHomeController;
use App\Http\Controllers\Author\AuthorPostController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ArchiveController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DisclaimerController;
use App\Http\Controllers\Front\FaqController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LanguageController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\PhotoController;
use App\Http\Controllers\Front\PollController;
use App\Http\Controllers\Front\VideoController;
use App\Http\Controllers\Front\PostController;
use App\Http\Controllers\Front\PrivacyController;
use App\Http\Controllers\Front\SubCategoryController;
use App\Http\Controllers\Front\SubscriberController;
use App\Http\Controllers\Front\TagController;
use App\Http\Controllers\Front\TermsController;
use App\Http\Controllers\Author\AuthorLoginController;
use App\Http\Controllers\Editor\AuthController;
use App\Http\Controllers\Editor\EditorAdvertisementController;
use App\Http\Controllers\Editor\EditorLoginController;
use App\Http\Controllers\Editor\EditorProfileController;

/* Front */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/language/switch', [LanguageController::class, 'switch_language'])->name('front_language');
Route::get('/subcategory-by-category/{id}', [HomeController::class, 'get_subcategory_by_category'])->name('subcategory-by-category');
Route::post('/search/result', [HomeController::class, 'search'])->name('search_result');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send-email', [ContactController::class, 'send_email'])->name('contact_form_submit');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy-policy', [PrivacyController::class, 'index'])->name('privacy');
Route::get('/disclaimer', [DisclaimerController::class, 'index'])->name('disclaimer');

// SiteMap
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// updated
Route::get('/news-detail/{slug}', [PostController::class, 'detailPost'])->name('news_detail');

Route::get('/category/{slug}', [SubCategoryController::class, 'index'])->name('category');
Route::get('/photo-gallery', [PhotoController::class, 'index'])->name('photo_gallery');
Route::get('/video-gallery', [VideoController::class, 'index'])->name('video_gallery');
Route::post('/subscriber', [SubscriberController::class, 'index'])->name('subscribe');
Route::get('/subscriber/verify/{token}/{email}', [SubscriberController::class, 'verify'])->name('subscriber_verify');
Route::post('/poll/submit', [PollController::class, 'submit'])->name('poll_submit');
Route::get('/poll/previous', [PollController::class, 'previous'])->name('poll_previous');
Route::post('/archive/show', [ArchiveController::class, 'show'])->name('archive_show');
Route::get('/archive/{year}/{month}', [ArchiveController::class, 'detail'])->name('archive_detail');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag_post_show');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-submit', [LoginController::class, 'login_submit'])->name('login_submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forget-password', [LoginController::class, 'forget_password'])->name('forget_password');
Route::post('/forget-password-submit', [LoginController::class, 'forget_password_submit'])->name('forget_password_submit');
Route::get('/reset-password/{token}/{email}', [LoginController::class, 'reset_password'])->name('reset_password');
Route::post('/reset-password-submit', [LoginController::class, 'reset_password_submit'])->name('reset_password_submit');
Route::get('/author/logout', [LoginController::class, 'logout'])->name('author_logout');


Route::post('/tag', [TagController::class, 'store'])->name('tags.store');
Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');


/* Author */

Route::get('author/logout', [AuthorLoginController::class, 'logout'])->name('author_logout');
Route::get('/author/home', [AuthorHomeController::class, 'index'])->name('author_home')->middleware('author:author');
Route::get('/author/edit-profile', [AuthorProfileController::class, 'index'])->name('author_profile')->middleware('author:author');
Route::post('/author/edit-profile-submit', [AuthorProfileController::class, 'profile_submit'])->name('author_profile_submit');


/* Author Post */
Route::get('/author/post/show', [AuthorPostController::class, 'show'])->name('author_post_show')->middleware('author:author');
Route::get('/author/post/create', [AuthorPostController::class, 'create'])->name('author_post_create')->middleware('author:author');
Route::post('/author/post/store', [AuthorPostController::class, 'store'])->name('author_post_store');
Route::get('/author/post/edit/{id}', [AuthorPostController::class, 'edit'])->name('author_post_edit')->middleware('author:author');
Route::post('/author/post/update/{id}', [AuthorPostController::class, 'update'])->name('author_post_update');
Route::delete('/author/post/delete/{id}', [AuthorPostController::class, 'delete'])->name('author_post_delete')->middleware('author:author');
Route::get('/author/post/tag/delete/{id}/{id1}', [AuthorPostController::class, 'delete_tag'])->name('author_post_delete_tag')->middleware('author:author');

/* Admin */
Route::get('/admin/home', [AdminHomeController::class, 'index'])->name('admin_home')->middleware('admin:admin');

/* Admin Login */
Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin_login');
Route::post('/admin/login-submit', [AdminLoginController::class, 'login_submit'])->name('admin_login_submit');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin_logout');
Route::get('/admin/forget-password', [AdminLoginController::class, 'forget_password'])->name('admin_forget_password');
Route::post('/admin/forget-password-submit', [AdminLoginController::class, 'forget_password_submit'])->name('admin_forget_password_submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminLoginController::class, 'reset_password'])->name('admin_reset_password');
Route::post('/admin/reset-password-submit', [AdminLoginController::class, 'reset_password_submit'])->name('admin_reset_password_submit');

/* Admin Profile */
Route::get('/admin/edit-profile', [AdminProfileController::class, 'index'])->name('admin_profile')->middleware('admin:admin');
Route::post('/admin/edit-profile-submit', [AdminProfileController::class, 'profile_submit'])->name('admin_profile_submit');

/* Admin Advertisements */
Route::get('/admin/home-advertisement', [AdminAdvertisementController::class, 'home_ad_show'])->name('admin_home_ad_show')->middleware('admin:admin');
Route::post('/admin/home-advertisement-update', [AdminAdvertisementController::class, 'home_ad_update'])->name('admin_home_ad_update');
Route::get('/admin/top-advertisement', [AdminAdvertisementController::class, 'top_ad_show'])->name('admin_top_ad_show')->middleware('admin:admin');
Route::post('/admin/top-advertisement-update', [AdminAdvertisementController::class, 'top_ad_update'])->name('admin_top_ad_update');
Route::get('/admin/sidebar-advertisement-view', [AdminAdvertisementController::class, 'sidebar_ad_show'])->name('admin_sidebar_ad_show')->middleware('admin:admin');
Route::get('/admin/sidebar-advertisement-create', [AdminAdvertisementController::class, 'sidebar_ad_create'])->name('admin_sidebar_ad_create')->middleware('admin:admin');
Route::post('/admin/sidebar-advertisement-store', [AdminAdvertisementController::class, 'sidebar_ad_store'])->name('admin_sidebar_ad_store');
Route::get('/admin/sidebar-advertisement-edit/{id}', [AdminAdvertisementController::class, 'sidebar_ad_edit'])->name('admin_sidebar_ad_edit')->middleware('admin:admin');
Route::post('/admin/sidebar-advertisement-update/{id}', [AdminAdvertisementController::class, 'sidebar_ad_update'])->name('admin_sidebar_ad_update');
Route::get('/admin/sidebar-advertisement-delete/{id}', [AdminAdvertisementController::class, 'sidebar_ad_delete'])->name('admin_sidebar_ad_delete')->middleware('admin:admin');

/* Admin Category */
Route::get('/admin/category/show', [AdminCategoryController::class, 'show'])->name('admin_category_show')->middleware('admin:admin');
Route::get('/admin/category/create', [AdminCategoryController::class, 'create'])->name('admin_category_create')->middleware('admin:admin');
Route::post('/admin/category/store', [AdminCategoryController::class, 'store'])->name('admin_category_store');
Route::get('/admin/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin_category_edit')->middleware('admin:admin');
Route::post('/admin/category/update/{id}', [AdminCategoryController::class, 'update'])->name('admin_category_update');
Route::get('/admin/category/delete/{id}', [AdminCategoryController::class, 'delete'])->name('admin_category_delete')->middleware('admin:admin');

/* Admin Sub category */
Route::get('/admin/sub-category/show', [AdminSubCategoryController::class, 'show'])->name('admin_sub_category_show')->middleware('admin:admin');
Route::get('/admin/sub-category/create', [AdminSubCategoryController::class, 'create'])->name('admin_sub_category_create')->middleware('admin:admin');
Route::post('/admin/sub-category/store', [AdminSubCategoryController::class, 'store'])->name('admin_sub_category_store');
Route::get('/admin/sub-category/edit/{id}', [AdminSubCategoryController::class, 'edit'])->name('admin_sub_category_edit')->middleware('admin:admin');
Route::post('/admin/sub-category/update/{id}', [AdminSubCategoryController::class, 'update'])->name('admin_sub_category_update');
Route::get('/admin/sub-category/delete/{id}', [AdminSubCategoryController::class, 'delete'])->name('admin_sub_category_delete')->middleware('admin:admin');

/* Admin Post */
Route::get('/admin/post/show', [AdminPostController::class, 'show'])->name('admin_post_show')->middleware('admin:admin');
Route::get('/admin/post/create', [AdminPostController::class, 'create'])->name('admin_post_create')->middleware('admin:admin');
Route::post('/admin/post/store', [AdminPostController::class, 'store'])->name('admin_post_store');
Route::get('/admin/post/edit/{id}', [AdminPostController::class, 'edit'])->name('admin_post_edit')->middleware('admin:admin');
Route::post('/admin/post/update/{id}', [AdminPostController::class, 'update'])->name('admin_post_update');
Route::get('/admin/post/delete/{id}', [AdminPostController::class, 'delete'])->name('admin_post_delete')->middleware('admin:admin');
Route::get('/admin/post/tag/delete/{id}/{id1}', [AdminPostController::class, 'delete_tag'])->name('admin_post_delete_tag')->middleware('admin:admin');

/* Admin Setting */
Route::get('/admin/setting', [AdminSettingController::class, 'index'])->name('admin_setting')->middleware('admin:admin');
Route::post('/admin/setting/update', [AdminSettingController::class, 'update'])->name('admin_setting_update');

/* Admin Photo Gallery */
Route::get('/admin/photo/show', [AdminPhotoController::class, 'show'])->name('admin_photo_show')->middleware('admin:admin');
Route::get('/admin/photo/create', [AdminPhotoController::class, 'create'])->name('admin_photo_create')->middleware('admin:admin');
Route::post('/admin/photo/store', [AdminPhotoController::class, 'store'])->name('admin_photo_store');
Route::get('/admin/photo/edit/{id}', [AdminPhotoController::class, 'edit'])->name('admin_photo_edit')->middleware('admin:admin');
Route::post('/admin/photo/update/{id}', [AdminPhotoController::class, 'update'])->name('admin_photo_update');
Route::get('/admin/photo/delete/{id}', [AdminPhotoController::class, 'delete'])->name('admin_photo_delete')->middleware('admin:admin');

/* Admin Video Gallery */
Route::get('/admin/video/show', [AdminVideoController::class, 'show'])->name('admin_video_show')->middleware('admin:admin');
Route::get('/admin/video/create', [AdminVideoController::class, 'create'])->name('admin_video_create')->middleware('admin:admin');
Route::post('/admin/video/store', [AdminVideoController::class, 'store'])->name('admin_video_store');
Route::get('/admin/video/edit/{id}', [AdminVideoController::class, 'edit'])->name('admin_video_edit')->middleware('admin:admin');
Route::post('/admin/video/update/{id}', [AdminVideoController::class, 'update'])->name('admin_video_update');
Route::get('/admin/video/delete/{id}', [AdminVideoController::class, 'delete'])->name('admin_video_delete')->middleware('admin:admin');

/* Admin Page About */
Route::get('/admin/page/about', [AdminPageController::class, 'about'])->name('admin_page_about')->middleware('admin:admin');
Route::post('/admin/page/about/update', [AdminPageController::class, 'about_update'])->name('admin_page_about_update');

/* Admin Page FAQ */
Route::get('/admin/page/faq', [AdminPageController::class, 'faq'])->name('admin_page_faq')->middleware('admin:admin');
Route::post('/admin/page/faq/update', [AdminPageController::class, 'faq_update'])->name('admin_page_faq_update');

/* Admin Page Terms */
Route::get('/admin/page/terms', [AdminPageController::class, 'terms'])->name('admin_page_terms')->middleware('admin:admin');
Route::post('/admin/page/terms/update', [AdminPageController::class, 'terms_update'])->name('admin_page_terms_update');

/* Admin Page Privacy */
Route::get('/admin/page/privacy', [AdminPageController::class, 'privacy'])->name('admin_page_privacy')->middleware('admin:admin');
Route::post('/admin/page/privacy/update', [AdminPageController::class, 'privacy_update'])->name('admin_page_privacy_update');

/* Admin Page Disclaimer */
Route::get('/admin/page/disclaimer', [AdminPageController::class, 'disclaimer'])->name('admin_page_disclaimer')->middleware('admin:admin');
Route::post('/admin/page/disclaimer/update', [AdminPageController::class, 'disclaimer_update'])->name('admin_page_disclaimer_update');

/* Admin Page Login */
Route::get('/admin/page/login', [AdminPageController::class, 'login'])->name('admin_page_login')->middleware('admin:admin');
Route::post('/admin/page/login/update', [AdminPageController::class, 'login_update'])->name('admin_page_login_update');

/* Admin Page Contact */
Route::get('/admin/page/contact', [AdminPageController::class, 'contact'])->name('admin_page_contact')->middleware('admin:admin');
Route::post('/admin/page/contact/update', [AdminPageController::class, 'contact_update'])->name('admin_page_contact_update');

/* Admin FAQ Section */
Route::get('/admin/faq/show', [AdminFaqController::class, 'show'])->name('admin_faq_show')->middleware('admin:admin');
Route::get('/admin/faq/create', [AdminFaqController::class, 'create'])->name('admin_faq_create')->middleware('admin:admin');
Route::post('/admin/faq/store', [AdminFaqController::class, 'store'])->name('admin_faq_store');
Route::get('/admin/faq/edit/{id}', [AdminFaqController::class, 'edit'])->name('admin_faq_edit')->middleware('admin:admin');
Route::post('/admin/faq/update/{id}', [AdminFaqController::class, 'update'])->name('admin_faq_update');
Route::get('/admin/faq/delete/{id}', [AdminFaqController::class, 'delete'])->name('admin_faq_delete')->middleware('admin:admin');

/* Admin Subscriber Show */
Route::get('/admin/subscriber/all', [AdminSubscriberController::class, 'show_all'])->name('admin_subscribers')->middleware('admin:admin');
Route::get('/admin/subscriber/send-email', [AdminSubscriberController::class, 'send_email'])->name('admin_subscribers_send_email')->middleware('admin:admin');
Route::post('/admin/subscriber/send-email-submit', [AdminSubscriberController::class, 'send_email_submit'])->name('admin_subscribers_send_email_submit');

/* Admin Live Channel */
Route::get('/admin/live-channel/show', [AdminLiveChannelController::class, 'show'])->name('admin_live_channel_show')->middleware('admin:admin');
Route::get('/admin/live-channel/create', [AdminLiveChannelController::class, 'create'])->name('admin_live_channel_create')->middleware('admin:admin');
Route::post('/admin/live-channel/store', [AdminLiveChannelController::class, 'store'])->name('admin_live_channel_store');
Route::get('/admin/live-channel/edit/{id}', [AdminLiveChannelController::class, 'edit'])->name('admin_live_channel_edit')->middleware('admin:admin');
Route::post('/admin/live-channel/update/{id}', [AdminLiveChannelController::class, 'update'])->name('admin_live_channel_update');
Route::get('/admin/live-channel/delete/{id}', [AdminLiveChannelController::class, 'delete'])->name('admin_live_channel_delete')->middleware('admin:admin');

/* Admin Online Poll */
Route::get('/admin/online-poll/show', [AdminOnlinePollController::class, 'show'])->name('admin_online_poll_show')->middleware('admin:admin');
Route::get('/admin/online-poll/create', [AdminOnlinePollController::class, 'create'])->name('admin_online_poll_create')->middleware('admin:admin');
Route::post('/admin/online-poll/store', [AdminOnlinePollController::class, 'store'])->name('admin_online_poll_store');
Route::get('/admin/online-poll/edit/{id}', [AdminOnlinePollController::class, 'edit'])->name('admin_online_poll_edit')->middleware('admin:admin');
Route::post('/admin/online-poll/update/{id}', [AdminOnlinePollController::class, 'update'])->name('admin_online_poll_update');
Route::get('/admin/online-poll/delete/{id}', [AdminOnlinePollController::class, 'delete'])->name('admin_online_poll_delete')->middleware('admin:admin');

/* Admin Social Item */
Route::get('/admin/social-item/show', [AdminSocialItemController::class, 'show'])->name('admin_social_item_show')->middleware('admin:admin');
Route::get('/admin/social-item/create', [AdminSocialItemController::class, 'create'])->name('admin_social_item_create')->middleware('admin:admin');
Route::post('/admin/social-item/store', [AdminSocialItemController::class, 'store'])->name('admin_social_item_store');
Route::get('/admin/social-item/edit/{id}', [AdminSocialItemController::class, 'edit'])->name('admin_social_item_edit')->middleware('admin:admin');
Route::post('/admin/social-item/update/{id}', [AdminSocialItemController::class, 'update'])->name('admin_social_item_update');
Route::get('/admin/social-item/delete/{id}', [AdminSocialItemController::class, 'delete'])->name('admin_social_item_delete')->middleware('admin:admin');

/* Admin Author */
Route::get('/admin/author/show', [AdminAuthorController::class, 'show'])->name('admin_author_show')->middleware('admin:admin');
Route::get('/admin/author/create', [AdminAuthorController::class, 'create'])->name('admin_author_create')->middleware('admin:admin');
Route::post('/admin/author/store', [AdminAuthorController::class, 'store'])->name('admin_author_store');
Route::get('/admin/author/edit/{id}', [AdminAuthorController::class, 'edit'])->name('admin_author_edit')->middleware('admin:admin');
Route::post('/admin/author/update/{id}', [AdminAuthorController::class, 'update'])->name('admin_author_update');
Route::get('/admin/author/delete/{id}', [AdminAuthorController::class, 'delete'])->name('admin_author_delete')->middleware('admin:admin');

/* Admin Editor */
Route::get('/admin/editor', [AdminEditorController::class, 'index'])->name('admin_editor_index');
Route::get('/admin/editor/create', [AdminEditorController::class, 'create'])->name('admin_editor_create');
Route::post('/admin/editor/store', [AdminEditorController::class, 'store'])->name('admin_editor_store');
Route::get('/admin/editor/edit/{id}', [AdminEditorController::class, 'edit'])->name('admin_editor_edit');
Route::post('/admin/editor/update/{id}', [AdminEditorController::class, 'update'])->name('admin_editor_update');
Route::get('/admin/editor/delete/{id}', [AdminEditorController::class, 'delete'])->name('admin_editor_delete');

/* Admin Language Section */
Route::get('/admin/language/show', [AdminLanguageController::class, 'show'])->name('admin_language_show')->middleware('admin:admin');
Route::get('/admin/language/create', [AdminLanguageController::class, 'create'])->name('admin_language_create')->middleware('admin:admin');
Route::post('/admin/language/store', [AdminLanguageController::class, 'store'])->name('admin_language_store');
Route::get('/admin/language/edit/{id}', [AdminLanguageController::class, 'edit'])->name('admin_language_edit')->middleware('admin:admin');
Route::post('/admin/language/update/{id}', [AdminLanguageController::class, 'update'])->name('admin_language_update');
Route::get('/admin/language/delete/{id}', [AdminLanguageController::class, 'delete'])->name('admin_language_delete')->middleware('admin:admin');

Route::get('/admin/language/update-detail/{id}', [AdminLanguageController::class, 'update_detail'])->name('admin_language_update_detail')->middleware('admin:admin');
Route::post('/admin/language/update-detail-submit/{id}', [AdminLanguageController::class, 'update_detail_submit'])->name('admin_language_update_detail_submit');


use App\Http\Controllers\Editor\EditorPostController;

// Route::prefix('editor')->middleware(['auth', 'editor'])->name('editor.')->group(function () {
//     // Route::get('posts', [EditorPostController::class, 'index'])->name('posts.index');
//     // Route::get('posts/create', [EditorPostController::class, 'create'])->name('posts.create');
//     // Route::post('posts', [EditorPostController::class, 'store'])->name('posts.store');
//     // Route::get('posts/{id}/edit', [EditorPostController::class, 'edit'])->name('posts.edit');
//     // Route::put('posts/{id}', [EditorPostController::class, 'update'])->name('posts.update');
// });

Route::prefix('admin')->name('admin.')->middleware(['admin:admin'])->group(function () {
    Route::resource('editor', App\Http\Controllers\Admin\AdminEditorController::class)
        ->except(['show']);
});

Route::prefix('editor')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('editor.login');
    Route::post('/login', [AuthController::class, 'login'])->name('editor.login.submit');
    // Route::post('/logout', [AuthController::class, 'logout'])->name('editor.logout');

    Route::middleware('auth:editor')->group(function () {
        Route::get('/home', [EditorPostController::class, 'dashboard'])->name('editor_home');

        Route::get('posts', [EditorPostController::class, 'index'])->name('posts.index');
        Route::get('posts/create', [EditorPostController::class, 'create'])->name('posts.create');
        Route::post('posts', [EditorPostController::class, 'store'])->name('posts.store');
        Route::get('posts/{id}/edit', [EditorPostController::class, 'edit'])->name('posts.edit');
        Route::put('posts/{id}', [EditorPostController::class, 'update'])->name('posts.update');
        Route::post('posts/{id}/approve', [EditorPostController::class, 'approve'])->name('posts.approve');
        Route::post('/editor/posts/{id}/cancel', [EditorPostController::class, 'cancel'])->name('editor.posts.cancel');
        Route::delete('/editor/posts/{id}/destroy', [EditorPostController::class, 'destroy'])->name('posts.destroy');
        Route::get('posts/{post}/tags/{tag}/delete', [EditorPostController::class, 'deleteTag'])->name('editor_post_delete_tag');

        /* Editor Advertisements */
        Route::get('/home-advertisement', [EditorAdvertisementController::class, 'home_ad_show'])->name('editor_home_ad_show')->middleware('admin:editor');
        Route::post('/home-advertisement-update', [EditorAdvertisementController::class, 'home_ad_update'])->name('editor_home_ad_update');
        Route::get('/top-advertisement', [EditorAdvertisementController::class, 'top_ad_show'])->name('editor_top_ad_show')->middleware('admin:editor');
        Route::post('/top-advertisement-update', [EditorAdvertisementController::class, 'top_ad_update'])->name('editor_top_ad_update');
        Route::get('/sidebar-advertisement-view', [EditorAdvertisementController::class, 'sidebar_ad_show'])->name('editor_sidebar_ad_show')->middleware('admin:editor');
        Route::get('/sidebar-advertisement-create', [EditorAdvertisementController::class, 'sidebar_ad_create'])->name('editor_sidebar_ad_create')->middleware('admin:editor');
        Route::post('/sidebar-advertisement-store', [EditorAdvertisementController::class, 'sidebar_ad_store'])->name('editor_sidebar_ad_store');
        Route::get('/sidebar-advertisement-edit/{id}', [EditorAdvertisementController::class, 'sidebar_ad_edit'])->name('editor_sidebar_ad_edit')->middleware('admin:editor');
        Route::post('/sidebar-advertisement-update/{id}', [EditorAdvertisementController::class, 'sidebar_ad_update'])->name('editor_sidebar_ad_update');
        Route::get('/sidebar-advertisement-delete/{id}', [EditorAdvertisementController::class, 'sidebar_ad_delete'])->name('editor_sidebar_ad_delete')->middleware('admin:editor');



        Route::get('profile/edit', [EditorProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile/update', [EditorProfileController::class, 'update'])->name('profile.update');
        Route::post('logout', [EditorProfileController::class, 'logout'])->name('logout');
    });
});


// Route::get('/editor/login', [EditorLoginController::class, 'showLoginForm'])->name('editor.login');
// Route::post('/editor/login-submit', [EditorLoginController::class, 'login_submit'])->name('editor_login_submit');
// Route::post('/editor/logout', [EditorLoginController::class, 'logout'])->name('editor.logout');


// Tambahkan prefix dan name group untuk editor
// Group untuk editor
Route::prefix('editor')->name('editor.')->middleware('auth:editor')->group(function () {
    Route::resource('editor', AdminEditorController::class)->except(['show']);
    Route::post('posts/{id}/approve', [EditorPostController::class, 'approve'])->name('posts.approve');
});

// Editor mengelola profil sendiri
// Route::prefix('editor')->name('editor.')->middleware('auth:editor')->group(function () {
//     // Route::get('profile/edit', [EditorProfileController::class, 'edit'])->name('profile.edit');
//     // Route::post('profile/update', [EditorProfileController::class, 'update'])->name('profile.update');
//     // Route::post('logout', [EditorProfileController::class, 'logout'])->name('logout');
// });
