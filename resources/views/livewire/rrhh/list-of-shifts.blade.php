<div>
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
                    <td class="bbd day"  style="text-align:center;width:54px;height:54px">
                            {{ $d->first()->id}}
                        	@if(isset($d) && count($d) )
                               @livewire('rrhh.change-shift-day-status',['shiftDay'=>$d->first()])
                            @else
                                N/A
                            @endif
                        
                    </td>
                @endfor    
			</tr>	
		@endforeach
        
        @else                           
            <td style="text-align:  center;" colspan="{{$days}}">SIN PERSONAL ASIGNADO</td>
        @endif


</div>
