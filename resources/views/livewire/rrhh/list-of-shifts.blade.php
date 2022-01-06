<style type="text/css">

.menu {
    display: none;
}

figure:active .menu,
figure:focus .menu {
    display: visible;
}
</style>

<style type="text/css">

	.seeBtn {
		color:blue;
	}
	.seeBtn:hover  {
		color:lightblue;
	}

</style>

<div>
   <div wire:loading>
              <i class="fas fa-spinner fa-pulse"></i>
        </div>

    @php
        $mInit = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-01");
        $mInit = explode(" ",$mInit);

        $mEnd = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-31");
        $mEnd = explode(" ",$mEnd);

    @endphp

    @livewire( 'rrhh.delete-shift',['startdate'=>$mInit[0],'enddate'=> $mEnd[0] ] )
    @livewire('rrhh.add-day-of-shift-modal')


    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")
        @foreach($staffInShift->sortBy('position') as $sis)
        @if( $sis->days()->whereBetween('day',[$mInit[0],$mEnd[0]])->count() > 0  || $actuallyShift->id == 99 )


            <tr>
                <td class="bless br cellbutton" >

                    @livewire( 'rrhh.delete-shift-button',['actuallyShiftUserDay'=>$sis])

                    {{--@livewire( 'rrhh.see-shift-control-form', ['usr'=>$sis->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth], key($loop->index) )--}}
                    <!-- <a href="{{ route('rrhh.shiftManag.seeShiftControlForm',['usr'=>$sis->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth]) }}">
                      <button class="only-icon seeBtn"  >
                        <i class="fa fa-eye seeBtn"></i>
                      </button>
  									</a> -->

                    {{ $sis->user->runFormat()}} - {{$sis->user->name}} {{$sis->user->fathers_family}}
                    <small>
                        @if( $sis->esSuplencia() == "Suplente" )
                            {{$sis->esSuplencia()}}
                        @else
                        <form method="POST" action="{{ route('rrhh.shiftManag.shiftupdate') }}">

                            @csrf
                            @method('POST')
                            <select class="form-control form-control-sm"  name="commentary" onchange="this.form.submit()">
                                <option value="titular" {{( $sis->esSuplencia() == "titular" )?"selected":""}} >Titular</option>
                                <option value="contrata" {{( $sis->esSuplencia() == "contrata" )?"selected":$sis->esSuplencia()}} >Contrata</option>
                                <option value="honorario" {{( $sis->esSuplencia() == "honorario" )?"selected":""}} >Honorario</option>
                            </select>
                            <input name="id" hidden value="{{$sis->id}}">
                        </form>
                        @endif
                    </small>
                </td>
                @for($j = 1; $j <= $days; $j++)
                    @php

                        $date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);
                        $date =explode(" ",$date);
                        $d = $sis->days()->where('day',$date[0])->get();

                    @endphp
                    <td class="bbd day "  style="text-align:center;width:54px;height:54px">
                            @if( isset($d))
                                @foreach($d as $dd)

                                    @livewire('rrhh.change-shift-day-status',['shiftDay'=>$dd,'loop'=>$loop->index],key($dd->id) )

                                @endforeach
                            @else
                                @livewire('rrhh.add-day-of-shift-button',['shiftUser'=>$sis,'day'=>$date])
                            @endif

                    </td>
                @endfor
            </tr>
        @endif
        @endforeach

        @else
            <td style="text-align:  center;" colspan="{{$days}}">SIN PERSONAL ASIGNADO </td>
        @endif

</div>
