 <div class="container">
       
        <?php


            $consensushalvinginterval = intval(525600 / 2.5); // consensus halving
            $z = 0;
            $substart = 10000;
            $generationspeed = 2.5;
            $numberofblockperday = 1440 / $generationspeed;
            $numberofblockperyear = $numberofblockperday * 365;
            $totalsupply = 0; // 1 Milliard  600 Millions
            $halvingvalue = 0.1618033988750; // golden ratio
            $nsyear = 0;
            $nsday = 0;

            echo _t("<small>Note: *average and rounded</small><br>");
            $height = $substart / $generationspeed;
            $nSubsidy = $substart;
            $years = ($height / $consensushalvinginterval) + 1;
            $halving = ($years) / $halvingvalue;
            $nSubsidy = $nSubsidy / ($halving);

            echo _t("<small>Subsidy starts at ") . intval($nSubsidy) . _t(" FRANC / block (Bitcoin at 50)") . "<br></small>";
            echo _t("<small>New block target is 1 block every " . $generationspeed . " minute (Bitcoin is 1 block every 10 minutes).<br></small>");
            echo _t("<small>After block 52000, Block subsidy is recalculated every block (Bitcoin every 210,000 blocks).<br></small>");
            echo _t("<small>Difficulty retarget is every 10 blocks or 25 minutes.(Bitcoin is 2016 block or 20160 minutes).<br></small>");
            echo _t("<small>Mining reward is divided by year/" . $halvingvalue . " every block (Bitcoin is divided by 2 every 210,000 blocks) after block 52000.<br></small>");
            echo "<hr><br>";

        ?>
    </div>
    <div class="container">
        <h1><?php echo _t("100 Years"); ?></h1>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
        <?php
            echo "<table class=\"blueTable\"><tr><th>Block</th><th>Year</th><th>Halving*</th><th>Subsidy/Block*</th><th>Subsidy/day*</th><th>Subsidy/Year*</th><th>Total Supply KYF*</th><th>Total Millions KYF*</th></tr>";
            $extotalsupply = 0;
            for ($i = 0; $i < 500000000; $i++) {
                $height = $i;
                $nSubsidy = $substart;
                $years = ($height / $consensushalvinginterval) + 1;
                if ($height <= 52000) {
                    $years = 1;
                } // private maning advantage 5177 KYF per Block
                $halving = $years / $halvingvalue;
                $nSubsidy = $nSubsidy / $halving;
                if ($nSubsidy < 1.0) {
                    break;
                }

                $nsyear += $nSubsidy;
                $nsday += $nSubsidy;

                //if ($height % 17520==0 || intval($height)==0) {
                if (intval($height % (210240)) == 0 && $years > 1) {
                    echo "<tr><td>" . $i . "</td><td>" . intval($years - 1) . "</td><td>" . nformat($halving) . "</td><td>" . nformat($nSubsidy) . "</td><td>" . nformat($nsday) . "</td><td>" . nformat($nsyear) . "</td><td>" . nformat($totalsupply - $nSubsidy) . "</td><td>" . nformat($totalsupply / 1000000) . "</td></tr>";
                    if ($z > 10000) {
                        break;
                    }
                    $z++;
          
                }

                $totalsupply += $nSubsidy;

                if ($height % $numberofblockperyear == 0) {
                    $nsyear = 0;
                }
                if ($height % $numberofblockperday == 0) {
                    $nsday = 0;
                }
                if ($years >= 100) {
                    break;
                }
                $extotalsupply = $totalsupply - $nSubsidy;
            }
            echo "</table>";
            /**
             * @param $i
             *
             * @return string
             */
            function nformat($i)
            {
                return number_format(intval($i), 0, ',', ' ');
            }

        ?>


        
    </div>
