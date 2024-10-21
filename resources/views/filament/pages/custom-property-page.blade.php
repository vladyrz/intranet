<x-filament-panels::page>

    <table>
        <tr>
            <td>Property id</td>
        </tr>

    @foreach ($properties as $property)
        <tr>
            <td>
                <a href="{{$property->link_propiedad}}">{{$property->link_propiedad}}</a>
            </td>
        </tr>
    @endforeach
    </table>

</x-filament-panels::page>
