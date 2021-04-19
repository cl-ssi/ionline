<div>
    <h1>{{$statusx}}</h1>
    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")

    	@foreach($staffInShift as $sis)
			<tr>
				<td class="bless br" >
                    <form method="POST" action="{{ route('rrhh.shiftsTypes.deleteassign') }}">
                        @csrf
                        @method('POST')
                        <input hidden name="idAssign" value="{{$sis->id}}">
                        <button class="only-icon"><i class="fa fa-close" style="color:red"></i></button> {{ $sis->user->runFormat()}} - {{$sis->user->name}}  
                    </form>
                </td>
                @for($j = 1; $j <= $days; $j++) 
                    @php
						$date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);
						$date =explode(" ",$date);
                        $d = $sis->days->where('day',$date[0]);
					@endphp
                    <td  style="text-align:center;width:54px;height:54px">
                        <div  class="bbd day" >
                        	@if(isset($d) && count($d) )
                                <button type="button" wire:click="editStatusDay({{$staffInShift}},{{$actuallyYear}},{{$actuallyMonth}},{{$days}})">
                                    @if($d->first()->working_day!="F")
                                    	{{$d->first()->working_day}}
                                    @else
                                    	-
                                    @endif
                                </button>
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                @endfor    
			</tr>	
		@endforeach
        
        @else                           
            <td style="text-align:  center;" colspan="{{$days}}">SIN PERSONAL ASIGNADO</td>
        @endif

</div>
