<style>
    .page-header {
        /*opacity: .1;*/
    }
</style>
<div class="col-lg-6 col-lg-offset-3">
    <div class="panel panel-minimal" style="margin-top:10%;">
        <div class="panel-body text-muted text-center">
            <i class="@yield('blankslate-icon-class')  fsize112"></i>
        </div>
        <div class="panel-body text-muted text-center">
            <h1 class="text-center fsize32 mb10 mt0">
                @yield('blankslate-title')
            </h1>
            <p class="pa10 text-center ">
                @yield('blankslate-text')
            </p>
            @yield('blankslate-body')
        </div>
    </div>
</div>
