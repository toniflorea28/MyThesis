<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function getAllAvailableJobs() {
        $jobs = Job::where('active', 1)->get();
        foreach ($jobs as $job) {
            $job->avatar = $job->user->avatar;
            $job->userFullName = $job->user->fullName;
            $job->username = $job->user->username;
            $job->blogPosted = Carbon::parse($job->created_at)->format('M d Y');
            $job->tags = [];
        }

        return response()->json($jobs);
    }

    public function getAllUserJobs() {
        $userId = Auth::id();
        $jobs = Job::where('user_id', $userId)->get();
        foreach ($jobs as $job) {
            $job->avatar = $job->user->avatar;
            $job->userFullName = $job->user->fullName;
            $job->username = $job->user->username;
            $job->blogPosted = Carbon::parse($job->created_at)->format('M d Y');
            $job->tags = [];
        }

        return response()->json($jobs);
    }

    public function getAvailableJobsForQuery(Request $request){
        $search_query = strip_tags($request->input('search'));

        $jobs = Job::where([['title', 'like', '%'.$search_query.'%'],['active', '=', 1]])
            ->orWhere([['excerpt', 'like', '%'.$search_query.'%'],['active', '=', 1]])
            ->orWhere([['content', 'like', '%'.$search_query.'%'],['active', '=', 1]])->get();

        foreach ($jobs as $job) {
            $job->avatar = $job->user->avatar;
            $job->userFullName = $job->user->fullName;
            $job->username = $job->user->username;
            $job->blogPosted = Carbon::parse($job->created_at)->format('M d Y');
            $job->tags = [];
        }

        return response()->json($jobs);
    }

    public function getTopJobs(){
        $jobs = Job::where('active', 1)->orderBy('comment', 'DESC')->take(4)->get();
        $response = (object)[];

        foreach ($jobs as $job) {
            $job->createdTime = Carbon::parse($job->created_at)->format('M d Y');
        }

        $jobCategories = JobCategory::take(5)->get();
        $parsedCategories = [];
        foreach ($jobCategories as $category) {
            array_push($parsedCategories, ['category' => $category->title, 'icon' => $category->icon]);
        }

        $response->categories = $parsedCategories;
        $response->recentPosts = $jobs;
        return response()->json($response);
    }

    public function getJobDetails($jobId) {
        $job = Job::find($jobId);
        $response = (object)[];

        $response->blog = $job;
        $response->blog->avatar = '/images/'.$job->user->avatar;
        $response->blog->userFullName = $job->user->fullName;
        $response->blog->username = $job->user->username;
        $response->blog->createdTime = Carbon::parse($job->created_at)->format('M d Y');
        $response->blog->content = $job->content;
        $response->blog->comments = 0;

        return response()->json($response);
    }

    public function toggleJob($jobId) {
        $job = Job::find($jobId);
        $user = Auth::user();

        if (!$user || !$job || $job->user_id != $user->id) {
            return response()->json([], 401);
        }

        $job->active = !$job->active;
        $job->save();
        return response()->json([], 204);
    }

    public function saveNewJobPost(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('jobImages'), $imageName);

        $job = new Job();
        $job->img = '/jobImages/'.$imageName;
        $job->title = $request->input('title');
        $job->user_id = Auth::id();
        $job->category_id = 0;
        $job->tags = $request->input('tags');
        $job->excerpt = $request->input('excerpt');
        $job->content = $request->input('content');
        $job->phone = $request->input('phone');
        $job->rating = 0;
        $job->location = $request->input('location');
        $job->comment = 0;
        $job->active = 1;
        $job->save();

        return response()->json(['status' => 200, 'id' => $job->id]);
    }
}
