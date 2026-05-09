<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Str;
use Yajra\DataTables\Facades\DataTables;
class ShortUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if($request->ajax()){
            //
            $auth = auth()->user();
            $authId = auth()->user()->id;
            if ($auth->hasRole('SuperAdmin')) {
                $shorturls_list = ShortUrl::select('id','original_url','short_url')->get();
            }else{
                $companyId = auth()->user()->company_id;
                $shorturls_list = ShortUrl::select('id','original_url','short_url')
                //->where('user_id',$authId)
                ->where('company_id',$companyId)
                ->get();
            }

            return DataTables::of($shorturls_list)
            ->addIndexColumn()
            ->editColumn('original_url' ,function($row){
                return '<a href="'.$row->original_url.'" target="_blank">'. $row->original_url .'</a>';
            })
            ->editColumn('short_url',function($row){
                return '<a href="'.route('open_shortcode',$row->short_url).'" target="_blank">'.route('open_shortcode',$row->short_url).'</a>';
            })
            ->addColumn('action',function($row){
                $copybtn = '<div class="btn-group copy-btn" data-copy="'.$row->short_url.'">
                                                    <a class="btn btn-primary" href="javascript:void(0)">
                                                        <i class="bi bi-files"></i>
                                                    </a>
                                                </div>';

                $trashbtn = '';
                if(auth()->user()->hasRole(['Admin','Member'])){
                $trashbtn = '<div class="btn-group"><form class="" action="'.route('shorturl.destroy',$row->id).'" method="POST">
                                                        '.csrf_field().'
                                                        '.method_field('DELETE').'
                                                        <button class="btn btn-danger" type="submit" onclick="return confirm("Are you sure?")">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>';
                }

                return $copybtn.' '.$trashbtn;
            })
            ->rawColumns([
                'original_url',
                'short_url',
                'action'
            ])->make(true);

        }
        return view('shorturl.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('shorturl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $auth = auth()->user();
        $request->validate([
            'original_url' => 'required|url|min:3'
        ]);

        $shortUrl = Str::random(8);
        $create_shortUrl = ShortUrl::create([
            'company_id' => $auth->company_id,
            'user_id' =>  $auth->id,
            'original_url' => $request->original_url,
            'short_url' => $shortUrl
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Short URL created successfully.',
            'data' => $create_shortUrl
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortUrl $shortUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        try{
            $shorturl = ShortUrl::findorfail($id);
            $shorturl->delete();
            return redirect()->back()->with('success','Short URL deleted successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function openShortCode($code){
      $checkCodeExit = ShortUrl::where('short_url', $code)->firstOrFail();
      //echo $checkCodeExit->original_url
      return redirect()->away($checkCodeExit->original_url);

    }
}

