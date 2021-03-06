<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class>
        <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
        <table>
            <tr>
                <th>제조회사</th>
                <th>자동차명</th>
                <th>제조연도</th>
            </tr>
        @foreach ($cars as $car)
        <tr>
            {{-- <td><a href="{{ route('cars.show',['cars'=>$car->id]) }}">{{ $car->company->name }}</td> --}}
            <td>{{$car->company->name}}</td>
            <td><a href="{{ route('cars.show',['car'=>$car->id]) }}">{{ $car->name}}</a></td>
            <td>{{$car->year}}</td>
        </tr>
        @endforeach
        </table>
        <div clas= "my-5 content-start">
            {{ $cars->links() }}
        </div>
    </div>
    </x-app-layout>