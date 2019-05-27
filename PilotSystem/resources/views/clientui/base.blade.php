<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') - FLYCOC</title>

        <link href="{{ asset('assets/css/client/main.css') }}" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{{ asset('assets/js/client/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/spinner/ui.spinner.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/spinner/jquery.mousewheel.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/excanvas.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/jquery.flot.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/jquery.flot.orderBars.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/jquery.flot.pie.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/jquery.flot.resize.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/charts/jquery.sparkline.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/uniform.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.cleditor.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.validationEngine-en.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.validationEngine.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.tagsinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/autogrowtextarea.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.maskedinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.dualListBox.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/jquery.inputlimiter.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/forms/chosen.jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/wizard/jquery.form.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/wizard/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/wizard/jquery.form.wizard.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/uploader/plupload.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/uploader/plupload.html5.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/uploader/plupload.html4.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/uploader/jquery.plupload.queue.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/tables/datatable.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/tables/tablesort.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/tables/resizable.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.tipsy.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.collapsible.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.prettyPhoto.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.progress.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.timeentry.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.colorpicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.jgrowl.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.breadcrumbs.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/ui/jquery.sourcerer.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/calendar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/plugins/elfinder.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/client/charts/chart.js') }}"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
    </head>

    <body @yield('body-attr')>
        @yield('main')

        <!-- 版权 -->
        <div id="footer">
                Copyright © 2004 - 2019  <a href="https://va.chinaFlier.com/" title="ChinaFlier" target="_blank">COC 航空人生</a> 飞行品质监控系统</div>
        </div>

        <script type="text/javascript" src="{{ asset('assets/js/client/client_function.js') }}"></script>
        @yield('script')
    </body>

</html>