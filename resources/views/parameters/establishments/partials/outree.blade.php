
<div id="tree" class="tree small">
    <ul>
        @include('parameters.establishments.partials.nodo',[
            'array' => $establishment->treeArray,
            'route' => $route,
        ])
    </ul>
</div>

<style>
    .tree li {
        list-style-type:none;
        margin:0;
        padding:5px 5px 0 5px;
        position:relative
    }
    .tree li::before, .tree li::after {
        content:'';
        left:-10px;
        position:absolute;
        right:auto
    }
    .tree li::before {
        border-left:1px solid #999;
        bottom:50px;
        height:100%;
        top:0;
        width:1px
    }
    .tree li::after {
        border-top:1px solid #999;
        height:20px;
        top:15px;
        width:15px
    }
    .tree li span:not(.glyphicon) {
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        display:inline-block;
        padding:4px 9px;
        text-decoration:none
    }
    .tree li.parent_li>span:not(.glyphicon) {
        cursor:pointer
    }
    .tree>ul>li::before, .tree>ul>li::after {
        border:0
    }
    .tree li:last-child::before {
        height:16px
    }
    .tree li.parent_li>span:not(.glyphicon):hover, .tree li.parent_li>span:not(.glyphicon):hover+ul li span:not(.glyphicon) {
        background:#eee;
        border:1px solid #999;
        padding:3px 8px;
        color:#000
    }
</style>