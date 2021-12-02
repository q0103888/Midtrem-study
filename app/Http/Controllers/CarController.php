<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
           1. DB에서 리스트를 가져온다.
           2. 그 리스트를 블레이드 컴포넌트에게 전달한다.
        */
        //$cars = Car::all();
        //Car::orderBy('created_at', 'desc')->get();
        //dd(request()->all());
        $cars = Car::latest()->paginate(5);
        //자료들을 시간 순으로 가져옴
        // dd($cars);
        return view('components.cars.index',['cars'=>$cars]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('components.cars.register-car', 
                ['companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $now = now();     
        // 1. 자동차 정보 저장에 필요한 데이터가 모두 적절한
        //    형태로 왔는지 정당성 검사를 수행하자.
        $data = $request->validate([
                        'image'=>'required|image',
                        'name'=>'required',
                        'company_id'=>'required',
                        'year'=>'required|numeric|min:1800|max:'.($now->year+1),
                        'price'=>'required|numeric|min:1',
                        'type'=>'required',
                        'style'=>'required'
                        ]);
                        //dd($data);
        // 2. 이미지를 파일 시스템의 특정 위치에 저장한다.
        // $fileName = null;
        // if($request->hasFile('image')) {
        // $fileName = time().'_'.
        // $request->file('image')->getClientOriginalName();
        // $path = $request->file('image')  
        //     ->storeAs('public/images', $fileName);
        // }                       
        // $input = array_merge($request->all(), 
        //     ["user_id"=>Auth::user()->id]);
        // if($fileName) {
        // $input = array_merge($input, ['image' => $fileName]);
        // }

        //2-1 수업내용
        $path = $request->image->store('images','public');
        $data = array_merge($data, ['image'=>$path]);

        // 3. 요청정보($request)에서 필요한 데이터를 꺼내가지고 DB에 저장한다
        Car::create($data);
        // 4. cars.index로 redirection  
        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        // 상세보기 페이지
        return view('components.cars.car-show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car, Company $companies)
    {
        $companies = Company::all();
        return view('components.cars.car-edit',
           compact(['car','companies'])); // ['car'=>$car]
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $now = now();     
        dd($request->image);
        // 1. 자동차 정보 저장에 필요한 데이터가 모두 적절한
        //    형태로 왔는지 정당성 검사를 수행하자.
        $data = $request->validate([
                        'image'=>'image',
                        'name'=>'required',
                        'company_id'=>'required',
                        'year'=>'required|numeric|min:1800|max:'.($now->year+1),
                        'price'=>'required|numeric|min:1',
                        'type'=>'required',
                        'style'=>'required'
                        ]);
                        // dd('original:'. $car->image);

        $path = null;
        if($request->image) { //기존 이미지를 변경하고자 하는 경우 
            Storage::delete($car->image);
            $path = $request->image->store('images','public');
        }

        if($path != null) {
             $data = array_merge($data, ['image'=>$path]);
        }
        // 3. 요청정보($request)에서 필요한 데이터를 꺼내가지고 DB에 저장한다

        //update set image=?, name=?, style=?, kind=?
        $car->update($data);

        // 4. cars.index로 redirection  

        // network tab에서 compact('car')를  이용했을 때
        // 서버에서 어떤 지시가 오는지 확인해보자
        return redirect()->route('cars.show', 
                ['car'=>$car->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
