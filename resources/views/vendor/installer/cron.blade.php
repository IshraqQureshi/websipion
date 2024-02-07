@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')

<form method="post">
    <div class="box box-primary borderless">
        <div class="skin-box-card">
            <div class="box-header">
                <h3 class="box-title">Cron jobs - Please add the following cron jobs to your server</h3>
            </div>
            <div class="box-body">
            <div class="alert alert-info">
                If you run into issues when setting up the cron jobs, please read <a target="_blank" href="https://ommune.com/sitedowndetector/documentation/Cron-Job.html"><em>this</em></a> article for solutions.<br />
            </div>

    Please note, below timings for running the cron jobs are the recommended ones, but if you feel you need to adjust them, go ahead.<br />    <br />
    <pre>
    </pre>

        If you have a control box like CPanel, Plesk, Webmin etc, you can easily add the cron jobs to the server cron.<br />
        In case you have shell access to your server, following commands should help you add the crons easily:
        <br /><br />

    <pre>
    # copy the current cron into a new file
    crontab -l > mwcron

    # add the new entries into the file


    # install the new cron
    crontab mwcron

    # remove the crontab file since it has been installed and we don't use it anymore.
    rm mwcron
    </pre>

    Or, if you like working with VIM, then you know you can manually add them.<br />
    Open the crontab in edit mode (<code>crontab -e</code>) add the cron jobs and save, that's all.
            <div class="clearfix"><!-- --></div>
            </div>
            <div class="box-footer">
                <div class="pull-right mobile-center">
                	 <a href="{{ route('LaravelInstaller::finish') }}" class="btn btn-primary btn-flat">{{ trans('Cron jobs are installed, continue.') }}</a>
                </div>
                <div class="clearfix"><!-- --></div>
            </div>
        </div>
    </div>
</form>

@endsection