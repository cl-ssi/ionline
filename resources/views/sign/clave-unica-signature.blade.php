<div class="content">
    <div class="left">
        <p class="text">Aprobado Digitalmente por:</p>
        <p class="text big bold">{{ $user->short_name }}</p>
        <p class="text small">Utilizando Clave Unica el día</p>
        <p class="text">{{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
    <div class="right">
        <img
            class="image"
            src="https://claveunica.gob.cl/_nuxt/img/claveunica.f53cf24.svg"
        />
    </div>
</div>

<style type="text/css">
    .image {
        width: 80%;
        padding-bottom: 0px;
        padding-top: 0px;
        padding-top: 0px;
        filter: invert(70%) sepia(30%) saturate(2100%) hue-rotate(184deg) brightness(87%) contrast(95%);
        color: #215aa1;
    }

    .content {
        border: 1px solid #000;
        margin: 0.5rem;
        display: flex;
        width: 300px;
    }

    .left {
        background-color: white;
        border: 1px solid #fff;
        padding: 0.5rem;
        flex-grow: 1;
        color: black;
        width: 50%;
    }

    .right {
        background-color: white;
        border: 1px solid #fff;
        padding: 5px;
        flex-grow: 1;
        width: 30%;
        text-align: right;
    }

    .text {
        font-size: 12px;
        margin-bottom: 1.5px;
        margin-top: 1.5px;
    }

    .bold {
        font-weight: bold;
    }

    .small {
        font-size: 11px;
    }

    .big {
        font-size: 16px;
    }

</style>