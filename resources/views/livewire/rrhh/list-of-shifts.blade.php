<div>
    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")
@livewire( 'rrhh.see-shift-control-form')
    	@foreach($staffInShift as $sis)
			<tr>
				<td class="bless br" >
                    
                        

                         {{ $sis->user->runFormat()}} - {{$sis->user->name}}

                    
                </td>
                @for($j = 1; $j <= $days; $j++) 
                    @php
						$date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);  
						$date =explode(" ",$date);
                        $d = $sis->days->where('day',$date[0]);
					@endphp
                    <td class="bbd day"  style="text-align:center;width:54px;height:54px">
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
