<?php
include_once(dirname(__FILE__).'/../../helpers/view_helper.php');
include_once(dirname(__FILE__).'/../../helpers/log/log_helper.php');
include_once(dirname(__FILE__).'/../../models/log/log_model.php');
$_log_helper = new LogHelper();

include_once('inc/i18n_strs.php'); 
include_once('js/list_js.php');
?>
<div class="col-md-12 statistics-container no-padding">

    <?php $_log_helper->render_statistic_menu(); ?>

    <div id="statistics-config" class="col-md-3 ui-widget-header no-padding">

        <div class="form-group period-config">
            <label class="title-pipe"> <?php _t('Period',true); ?> </label>
            <div class="date-range-filter">
                <p>
                    <span> <?php _e('From','tainacan') ?> </span>
                    <input size="7" type="text" class="input_date form-control" value="" placeholder="dd/mm/aaaa" id="from_period" name="from_period">
                </p>
                <p>
                    <span> <?php _e('until','tainacan') ?> </span>
                    <input type="text" class="input_date form-control" size="7" value="" placeholder="dd/mm/aaaa" id="to_period" name="to_period"> <br />
                </p>
            </div>
        </div>
        <div class="form-group">
            <label for="object_tags" class="title-pipe"> <?php _t('Report type',true); ?> </label>
            <div id="report_type_stat"></div>
        </div>
    </div>

    <div id="charts-display" class="col-md-9">

        <?php // include_once "inc/pdf.php"; ?>

        <div class="chart-header btn-group col-md-12">
            <?php $_log_helper->render_config_title(_t('Repository Statistics')); ?>
            <div class="user-config-control col-md-12 no-padding">
                <div class="col-md-4 pull-left no-padding">
                    <span class="config-title"><?php _t('Filters:',1); ?></span>
                    <span class="current-chart"><?php _t('User Stats',1); ?></span>
                </div>

                <div class="col-md-2 pull-right no-padding">
                    <button class="btn btn-default" data-toggle="dropdown" type="button" id="downloadStat">
                        <?php _t('Download: ',true); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="downloadStat">
                        <li> <a href="javascript:void(0)" class="dl-pdf"> <?php _t('PDF',1); ?> </a> </li>
                        <li> <a href="" class="dl-csv"> <?php _t('CSV',1); ?> </a> </li>
                        <li> <a href="" class="dl-xls"> <?php _t('XLS',0); ?> </a> </li>
                    </ul>
                </div>

                <div class="col-md-2 pull-right no-padding">
                    <span class="config-title"><?php _t('Mode:',1); ?></span>

                    <button data-toggle="dropdown" class="btn btn-default" id="statChartType" type="button">
                        <img src="<?php echo $_log_helper->getChartsType()[0]['img']; ?>" alt="<?php echo $_log_helper->getChartsType()[0]['className']; ?>">
                    </button>

                    <ul class="dropdown-menu statChartType" aria-labelledby="statChartType">
                        <?php foreach ($_log_helper->getChartsType() as $chart): ?>
                            <li class="<?php echo $chart['className']; ?>">
                                <a href="javascript:void(0)" class="change-mode" data-chart="<?php echo $chart['className'] ?>">
                                    <img src="<?php echo $chart['img'] ?>" />
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>
        </div>

        <div id="charts-container" class="col-md-12">
            <div id="chart_div"></div> <!--Div that will hold the pie chart-->
            <div id="piechart_div" class="hide"></div>
            <div id="barchart_div" class="hide"></div>
        </div>
        
        <div id="charts-resume" class="col-md-12">
            <table>
                <tbody>
                <tr class="headers"> <th class="curr-parent"> <?php _t('Status:',1); ?> </th> </tr>
                <tr class="content"> <td class="curr-filter"> <?php _t('Users:',1); ?> </td> </tr>
                </tbody>
            </table>

        </div>
    </div>

    <div class="temp-set" style="display: none"></div>

</div>