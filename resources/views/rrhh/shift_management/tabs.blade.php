<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'dashboard')?'active':'' }}" name="indexTab" aria-current="page" href="{{ route('rrhh.shiftManag.shiftReports') }}">Dashboard</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'indexTab')?'active':'' }}" name="indexTab" aria-current="page" href="{{ route('rrhh.shiftManag.index') }}">Gestión de Turnos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'shiftTypeTab')?'active':'' }}"  name="shiftTypeTab" href="{{ route('rrhh.shiftsTypes.index') }}">Tipos de Turnos (Series)</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'MyShiftTab')?'active':'' }}"  name="MyShiftTab" href="{{ route('rrhh.shiftManag.myshift') }}">Mi Turno</a>
  </li>
  <li class="nav-item">
    <a class="nav-link  {{ ($actuallyMenu == 'availableShifts')?'active':'' }}" name="availableShifts" href="{{ route('rrhh.shiftManag.availableShifts') }}" tabindex="-1">Turnos Disponibles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'shiftclose')?'active':'' }}" name="indexTab" aria-current="page" href="{{ route('rrhh.shiftManag.closeShift') }}">Cierre de turno 	</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ ($actuallyMenu == 'reports')?'active':'' }}" name="indexTab" aria-current="page" href="{{ route('rrhh.shiftManag.shiftReports') }}">Reportes</a>
  </li>
</ul>

