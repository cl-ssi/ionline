@canany(['Pharmacy: SSI (id:1)', 'Pharmacy: REYNO (id:2)', 'Pharmacy: APS (id:3)'])
<ul class="nav nav-tabs mb-3">
    @canany(['Pharmacy: purchase'])
        <li class="nav-item">
            <a class="nav-link"
                href="{{ route('pharmacies.products.purchase.index') }}">
                <i class="fas fa-shopping-cart"></i> Compras</a>
        </li>
    @endcan

    @canany(['Pharmacy: receiving'])
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('pharmacies.products.receiving.index') }}">
            <i class="fas fa-shopping-basket"></i> Ingresos</a>
    </li>
    @endcan

    @canany(['Pharmacy: dispatch'])
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('pharmacies.products.dispatch.index') }}">
            <i class="fas fa-shipping-fast"></i> Egresos</a>
    </li>
    @endcan

    @canany(['Pharmacy: transfer'])
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('pharmacies.products.transfer.index') }}">
            <i class="fas fa-clipboard-list"></i> Stocks Ortesis</a>
    </li>
    @endcan

    @canany(['Pharmacy: deliver'])
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('pharmacies.products.deliver.index') }}">
            <i class="fas fa-dolly"></i> Entregas Ortesis</a>
    </li>
    @endcan

    @canany(['Pharmacy: reports'])
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle"
            href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-file-invoice"></i> Reportes</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.products') }}">
                <i class="fas fa-file-alt"></i> Productos</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.bincard') }}">
                <i class="fas fa-file-alt"></i> Bincard</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.purchase_report') }}">
                <i class="fas fa-file-alt"></i> Compras</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.informe_movimientos') }}">
                <i class="fas fa-file-alt"></i> Movimientos</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.product_last_prices') }}">
                <i class="fas fa-file-alt"></i> Últimos precios productos</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.reports.consume_history') }}">
                <i class="fas fa-file-alt"></i> Consumos históricos</a>


        </div>
    </li>
    @endcan

    @canany(['Pharmacy: mantenedores'])
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
            href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-wrench"></i> Mantenedores</a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

            <a class="dropdown-item"
                href="{{ route('pharmacies.products.index') }}">
                <i class="fas fa-pills"></i> Productos</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.establishments.index') }}">
                <i class="fas fa-clinic-medical"></i> Establecimientos</a>

            <a class="dropdown-item"
                href="{{ route('pharmacies.suppliers.index') }}">
                <i class="fas fa-industry"></i> Proveedores</a>

                <a class="dropdown-item"
                    href="{{ route('pharmacies.programs.index') }}">
                    <i class="fas fa-industry"></i> Programas</a>

        </div>
    </li>
    @endcanany

</ul>
@endcan
