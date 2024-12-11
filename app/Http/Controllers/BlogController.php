<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        // Fetch all blog posts
        $blogPosts = BlogPost::all();

        return view('blog', compact('blogPosts'));
    }
    public function show($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('blog.showblog', compact('post'));
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'required|string|max:255',
        ]);
    
        // Handle file upload
        $path = $request->file('file')->store('images/blog', 'public');
    
        // Create new blog post
        BlogPost::create([
            'title' => $request->title, // Assuming title is same as caption
            'caption' => $request->caption,
            'image' => $path,
        ]);
    
        return redirect()->route('blog')->with('success', 'Blog post uploaded successfully!');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|string|max:255',
            'caption' => 'required|string|max:255',
        ]);
    
        if ($request->hasFile('file')) {
            // Store the uploaded file in 'public/storage/uploads' and return the file path
            $fileName = $request->file('file')->store('uploads', 'public');
            
            // Store the file path, title, and caption in the database
            BlogPost::create([
                'image' => $fileName,
                'title' => $request->input('title'),
                'caption' => $request->input('caption'),
            ]);
        }
    
        return redirect()->back()->with('success', 'Blog post uploaded successfully!');
    }
    public function destroy($id)
{
    $post = BlogPost::findOrFail($id);

    // Optionally, delete the image file from storage
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }

    // Delete the blog post from the database
    $post->delete();

    return redirect()->back()->with('success', 'Blog post deleted successfully!');
}

}
