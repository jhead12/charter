<?php
	function getPagingString($baseUrl, $startRec, $pageSize, $pageNumberCount, $recCount, &$smarty) {
        $credit = intval($pageNumberCount);
		$hc = $credit/2;

		$currentPageNo = $startRec/$pageSize+1;
		$maxPage = intval(ceil($recCount/$pageSize));
        $nextLink = array();
        $prevLink = array();
        $startCredit = $currentPageNo-$hc;
        if($startCredit < 1) $startCredit = 1;
        $startRecofPaging = ($startCredit-1)*$pageSize;
        for($i = $startRecofPaging, $j = $startCredit; $credit > 0 && $j <= $maxPage; $i+=$pageSize, $credit--, $j++) {
            $pagination[] = array(
                "number"    => $j,
                "startRec"  => $i,
                "method"    => $baseUrl."&amp;startRec=".$i
            );
        }
        if($credit > 0) {
            for($i = $startRecofPaging-$pageSize, $j = $startCredit-1; $credit > 0 && $j > 0; $j--, $i-=$pageSize, $credit--){
                $pagination[] = array(
                    "number"    => $j,
                    "startRec"  => $i,
                    "method"    => $baseUrl."&amp;startRec=".$i
                );
            }    
        }
        /*
		if($currentPageNo <= $hc) {
			for($i = 0, $j = 1; $credit > 0 && $j <= $maxPage; $i+=$pageSize, $credit--, $j++) {
				$pagination[] = array(
					"number"    => $j,
					"startRec"  => $i,
					"method"    => $baseUrl."&amp;startRec=".$i
				);
			}
		}
		else if($currentPageNo > $maxPage - $hc + 1) {
			for($i = ($maxPage-$pageSize)*$pageSize, $j = $maxPage-$hc+4; $credit > 0 && $j <= $maxPage; $i+=$pageSize, $credit--, $j++) {
				$pagination[] = array(
					"number"    => $j,
					"startRec"  => $i,
					"method"    => $baseUrl."&amp;startRec=".$i
				);
			}
		}
		else {
			for($i = ($currentPageNo-$hc)*$pageSize, $j = $currentPageNo-$hc-1; $credit > 0 && $j <= $maxPage; $i+=$pageSize, $credit--, $j++) {
				$pagination[] = array(
					"number"    => $j,
					"startRec"  => $i,
					"method"    => $baseUrl."&amp;startRec=".$i
				);
			}
		}   */
        if(isset($pagination) && is_array($pagination))
            sort($pagination);

		if($startRec == 0 && $recCount < $pageSize) {
			$nextLink = "";
			$prevLink = "";
		}
		else if($startRec == 0 && $recCount > $pageSize) {
			$nextLink = array(
				"startRec"  => $startRec+$pageSize,
				"method"    => $baseUrl."&amp;startRec=".($startRec+$pageSize)
			);
			$prevLink = "";
		}
		else if($startRec+$pageSize >= $recCount && $startRec != 0) {
			$nextLink = "";
			$prevLink = array(
				"startRec"  => $startRec-$pageSize,
				"method"    => $baseUrl."&amp;startRec=".($startRec-$pageSize)
			);
		}
		else if($recCount > $pageSize) {
			$nextLink = array(
				"startRec"  => $startRec+$pageSize,
				"method"    => $baseUrl."&amp;startRec=".($startRec+$pageSize)
			);
			$prevLink = array(
				"startRec"  => $startRec-$pageSize,
				"method"    => $baseUrl."&amp;startRec=".($startRec-$pageSize)
			);
		}
		$smarty->assign("recCount", $recCount);
		$smarty->assign("startRec", $startRec);
		$smarty->assign("pageSize", $pageSize);
		if(!empty($pagination))
			$smarty->assign("pagination", $pagination);
		$smarty->assign("nextLink", $nextLink);
		$smarty->assign("prevLink", $prevLink);
		//return $smarty->fetch("paging.tpl");
	}
?>