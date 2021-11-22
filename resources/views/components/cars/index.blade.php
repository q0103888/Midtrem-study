<x-app-layout>
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
        <td>{{$car->company->name}}</td>
        <td>{{$car->name}}</td>
        <td>{{$car->year}}</td>
    </tr>
    @endforeach
    </table>
    <div clas= "my-5 content-start">
        {{ $cars->links() }}
    </div>
</div>
</x-app-layout>