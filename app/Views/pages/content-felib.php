<!-- CONTENT -->

<?php 
use App\Models\ExpedientesModel;
$modelExp = new ExpedientesModel();
$felipP1 = $modelExp->getTotalFelibCityCouncils('felib_p1');
$felipP1CouncilList = $modelExp->getCityCouncilsList('felib_p1');
$felipP2 = $modelExp->getTotalFelibCityCouncils('felib_p2');
$felipP2CouncilList = $modelExp->getCityCouncilsList('felib_p2');
$felipP3 = $modelExp->getTotalFelibCityCouncils('felib_p3');
$felipP3CouncilList = $modelExp->getCityCouncilsList('felib_p3');
$felipP4 = $modelExp->getTotalFelibCityCouncils('felib_p4');
$felipP4CouncilList = $modelExp->getCityCouncilsList('felib_p4');
$felipP5 = $modelExp->getTotalFelibCityCouncils('felib_p5');
$felipP5CouncilList = $modelExp->getCityCouncilsList('felib_p5');
$felipP6 = $modelExp->getTotalFelibCityCouncils('felib_p6');
$felipP6CouncilList = $modelExp->getCityCouncilsList('felib_p6');
$felipP7 = $modelExp->getTotalFelibCityCouncils('felib_p7');
$felipP7CouncilList = $modelExp->getCityCouncilsList('felib_p7');
$felipP8 = $modelExp->getTotalFelibCityCouncils('felib_p8');
$felipP8CouncilList = $modelExp->getCityCouncilsList('felib_p8');
$felipP9 = $modelExp->getTotalFelibCityCouncils('felib_p9');
$felipP9CouncilList = $modelExp->getCityCouncilsList('felib_p9');
$felipP10 = $modelExp->getTotalFelibCityCouncils('felib_p10');
$felipP10CouncilList = $modelExp->getCityCouncilsList('felib_p10');
$felipP11 = $modelExp->getTotalFelibCityCouncils('felib_p11');
$felipP11CouncilList = $modelExp->getCityCouncilsList('felib_p11');
$felipP12 = $modelExp->getTotalFelibCityCouncils('felib_p12');
$felipP12CouncilList = $modelExp->getCityCouncilsList('felib_p12');
$felipP13 = $modelExp->getTotalFelibCityCouncils('felib_p13');
$felipP13CouncilList = $modelExp->getCityCouncilsList('felib_p13');
$felipP14 = $modelExp->getTotalFelibCityCouncils('felib_p14');
$felipP14CouncilList = $modelExp->getCityCouncilsList('felib_p14');
$felipP15 = $modelExp->getTotalFelibCityCouncils('felib_p15');
$felipP15CouncilList = $modelExp->getCityCouncilsList('felib_p15');
?>
<div class="row">
  <div class="col">
	<div id="body">
    <h1>Resum FELIB</h1>
    <h2>Programes sol·licitats:</h2>
    <div>
        <ul>
        <li for = "felib_p1" class="main" >
					<?php echo lang('message_lang.felib_short_p1').": <span class='alert alert-info'>".$felipP1;?> ajuntaments</span>
          <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP1CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>  
				</li>

        <li for = "felib_p2" class="main" >
					<?php echo lang('message_lang.felib_short_p2').": <span class='alert alert-info'>".$felipP2;?> ajuntaments</span>
            <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP2CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p3" class="main" >
					<?php echo lang('message_lang.felib_short_p3').": <span class='alert alert-info'>".$felipP3;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP3CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p4" class="main" >
					<?php echo lang('message_lang.felib_short_p4').": <span class='alert alert-info'>".$felipP4;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP4CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p5" class="main" >
					<?php echo lang('message_lang.felib_short_p5').": <span class='alert alert-info'>".$felipP5;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP5CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p6" class="main" >
					<?php echo lang('message_lang.felib_short_p6').": <span class='alert alert-info'>".$felipP6;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP6CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p7" class="main" >
					<?php echo lang('message_lang.felib_short_p7').": <span class='alert alert-info'>".$felipP7;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP7CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p8" class="main" >
					<?php echo lang('message_lang.felib_short_p8').": <span class='alert alert-info'>".$felipP8;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP8CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p9" class="main" >
					<?php echo lang('message_lang.felib_short_p9').": <span class='alert alert-info'>".$felipP9;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP9CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p10" class="main" >
					<?php echo lang('message_lang.felib_short_p10').":<span class='alert alert-info'> ".$felipP10;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP10CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p11" class="main" >
					<?php echo lang('message_lang.felib_short_p11').":<span class='alert alert-info'> ".$felipP11;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP11CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p12" class="main" >
					<?php echo lang('message_lang.felib_short_p12').":<span class='alert alert-info'> ".$felipP12;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP12CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p13" class="main" >
					<?php echo lang('message_lang.felib_short_p13').":<span class='alert alert-info'> ".$felipP13;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP13CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p14" class="main" >
					<?php echo lang('message_lang.felib_short_p14').":<span class='alert alert-info'> ".$felipP14;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP14CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>

        <li for = "felib_p15" class="main" >
					<?php echo lang('message_lang.felib_short_p15').":<span class='alert alert-info'> ".$felipP15;?> ajuntaments</span>
                    <div class = "lista-exped-wrapper">
            <div class = "header-wrapper">
              <div class="header-wrapper-col">Ajuntament</div><div class="header-wrapper-col">Responsable</div><div class="header-wrapper-col">Tècnic</div>
            </div>
            <?php foreach($felipP15CouncilList as $councilItem):?>
              <div id ="fila" class = "detail-wrapper">
                <?php 
                $councilName = explode("#", $councilItem['cityCouncil']);
                echo "<span class = 'detail-wrapper-col'>".$councilName[1]."</span><span class = 'detail-wrapper-col'>".$councilItem['responsable_felib']."</span><span class = 'detail-wrapper-col'>".$councilItem['tecnico_felib'];?></span>
              </div>
            <?php endforeach;?>
          </div>
				</li>
        </ul>
    </div>
</div>

  </div>
</div>



<style>
.alert {
  padding: 0;
}  
.lista-exped-wrapper {
  width: 100%;
}
.header-wrapper {
  display: inline-grid;
  grid-template-columns: 33% 33% 33%;
  padding-bottom: 4px;
  width: 100%;
}

.header-wrapper-col {
  background-color: #003747;
  color: #fff;
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 4px;
  text-align: left;
}
.detail-wrapper {
  display: inline-grid;
  grid-template-columns: 33% 33% 33%;
  background-color: #f1efef;
  padding: 1px 0 1px 0;
  width: 100%;
}
</style>