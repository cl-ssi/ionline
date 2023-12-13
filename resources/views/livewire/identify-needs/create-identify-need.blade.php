<div>
    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Asunto				
                    </td>
                    <td>
                        <fieldset class="form-group col-md-12 col-12">
                            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.700ms="subject" placeholder="Nombre del Proceso">
                        </fieldset>
                    </td>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Cual es la causa, necesidad o problemática de capacitación en relación a la conducta observada de 
                        desempeño o aplicación de normativas de modo general en su unidad 				
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="reason">{{ $reason }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        En relación al punto anterior y de acuerdo a su observación, indique que conductas los funcionarios no 
                        realizan, lo que afecta de manera directa el desempeño o bien el cumplimiento de normativas (especifico)
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="behaviors">{{ $behaviors }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Que evidencias tiene para definir las causas anteriomente señaladas
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="for_performance_evaluation" wire:model.debounce.700ms="performanceEvaluation">
                            <label class="form-check-label" for="flexCheckDefault">
                                Observación directa del desempeño (brechas de competencias detectadas)												
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="for_observation_of_performance" wire:model.debounce.700ms="observationOfPerformance">
                            <label class="form-check-label" for="flexCheckDefault">
                                Evaluación de desempeño (brechas de competencias informadas)												
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="for_report_from_other_users" wire:model.debounce.700ms="reportFromOtherUsers">
                            <label class="form-check-label" for="flexCheckDefault">
                                Reporte de otros usuarios, colaboradores                                        												    											
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="for_organizational_unit_indicators" wire:model.debounce.700ms="organizationalUnitIndicators">
                            <label class="form-check-label" for="flexCheckDefault">
                                Indicadores de la Unidad                               																					
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="for_other" wire:model.debounce.300ms="other">
                            <label class="form-check-label" for="flexCheckDefault">
                                Otras (especifique, ejemplo cumplimiento normativa n°X)																				
                            </label>
                        </div>
                        <fieldset class="form-group col-md-12 col-12">
                            <input class="form-control" type="text" autocomplete="off" wire:model.debounce.700ms="otherDetail" {{ $otherDetailInputStatus }} placeholder="Detalle">
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Indique cual es la META cuantificable que la unidad o institución debe alcanzar en relación al 
                        eje estratégico seleccionado (Ejemplo: que los funcionarios reduzcan un 80%...)  				
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="goal">{{ $goal }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Indique cual es el RESULTADOS ESPERADOS a corto o mediano plazo que el funcionario, unidad o 
                        institución debe alcanzar en relación al eje estratégico seleccionado (ejemplo: Que los 
                        funcionarios conozcan las normativas…)
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="expectedResults">{{ $expectedResults }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Indique cual es el IMPACTO a largo plazo que el funcionario, Unidad  o institución debe alcanzar 
                        en relación al eje estratégico seleccionado
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="longtermImpact">{{ $longtermImpact }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Indique que RESULTADOS INMEDIATOS son lo esperado de esta capacitación en relación con el eje 
                        estratégico seleccionado
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="immediateResults">{{ $immediateResults }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        OBJETIVO DE DESEMPEÑO (Es aquello que debe hacer la persona en el lugar de trabajo).				
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="performanceGoals">{{ $performanceGoals }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        OBJETIVOS DE APRENDIZAJE (describe una competencia que será adquirida por el participante 
                        del curso, por tal razón, deberían especificarse para el curso y para cada tarea asignada).
                    </td>
                    <td class="text-center">
                        <div class="form-row">
                            <div class="col-12">
                                <button class="btn btn-sm text-white btn-primary" wire:click.prevent="add({{$i}})"><i class="fas fa-plus"></i> Agregar</button>
                            </div>
                        </div>

                        @foreach($inputs as $key => $value)
                            <div class="row mt-3">
                                <div class="col-md-10 col-12">
                                    <input type="text" class="form-control" wire:model.debounce.700ms="learningGoalsDescriptions.{{ $key }}" id="for_description" wire:key="value-{{ $value }}" placeholder="" required>
                                </div>
                                <div class="col-md-2 col-12">
                                    <button class="btn btn-danger" wire:click.prevent="remove({{$key}})">Eliminar</button>
                                </div>
                            </div>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Nivel Actual de la necesidad de Capacitación
                    </td>
                    <td class="text-center">
                        <fieldset class="form-group">
                            <select class="form-select" wire:model="currentTrainingLevel">
                                <option value="">Seleccione</option>
                                <option value="insufficient">Insuficiente</option>
                                <option value="basic">Básico</option>
                                <option value="average">Medio</option>
                                <option value="higher">Superior</option>
                            </select>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        A que nivel se considera esta necesidad de capacitación
                    </td>
                    <td class="text-center">
                        <fieldset class="form-group">
                            <select class="form-select" wire:model="needTrainingLevel">
                                <option value="">Seleccione</option>
                                <option value="personal">Personal</option>
                                <option value="departamento">Para el equipo de trabajo (Departamento)</option>
                                <option value="subdirección">Para el equipo de trabajo (Subdirección)</option>
                                <option value="estamento">Para el Estamento al que pertenece</option>
                                <option value="establecimiento">Para el Establecimiento al que pertenece</option>
                                <option value="otro">Otro tipo de asociación indicar el grupo o los funcionarios que lo componen</option>
                                <option value="red asistencial">Para la Red Asistencial</option>
                            </select>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Tipo de competencia requerida
                    </td>
                    <td class="text-center">
                        <fieldset class="form-group">
                            <select class="form-select" wire:model="expertiseRequired">
                                <option value="">Seleccione</option>
                                <option value="planta">Requerimiento de capacitación por planta</option>
                                <option value="desarrollo organizacional">Requerimiento de capacitación para el desarrollo organizacional</option>
                            </select>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        Justifique las consecuencias de no intervenir en esta necesidad, problema o desafio. 
                        Es decir, porque debe ser seleccionado su proyecto de capacitación
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="justification">{{ $justification }}</textarea>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="text-align: justify;">
                        ¿Cómo cree ud. que la capacitación puede ayudar a resolver la necesidad/problema/desafío? 
                        ¿ha considerado otras soluciones?¿Cuáles? Ejemplo (intervención en la unidad desde calidad) 			
                    </td>
                    <td>
                        <fieldset class="form-group">
                            <textarea class="form-control" id="for_body" rows="3" wire:model.debounce.700ms="canSolveTheNeed">{{ $canSolveTheNeed }}</textarea>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <button wire:click="save('save')" class="btn btn-primary float-end" type="button">
                <i class="fas fa-save"></i> Guardar
            </button>
            {{--<button wire:click="save('sent')" class="btn btn-success float-end me-2" type="button" @if($purchasePlanToEdit && $purchasePlanToEdit->hasApprovals()) disabled @endif>
                <i class="fas fa-paper-plane"></i> Guardar y Enviar
            </button>--}}
        </div>
    </div>
</div>
