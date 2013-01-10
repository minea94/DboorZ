<?php
/**
*
* @ This file is created by Decodeby.US
* @ deZender Public (PHP5 Decompiler)
*
* @	Version			:	1.0.0.0
* @	Author			:	Ps2Gamer & Cyko
* @	Release on		:	30.05.2011
* @	Official site	:	http://decodeby.us
*
*/

class StatisticsModel extends ModelBase
{

    public function tatarRaised( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) FROM p_queue q WHERE q.proc_type=%s", array(
            QS_TATAR_RAISE
        ) ) == 0;
    }

    public function getTatarVillagesList( )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\tv.id,\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.alliance_id,\r\n\t\t\t\tv.player_name,\r\n\t\t\t\tv.village_name,\r\n\t\t\t\tv.alliance_name,\r\n\t\t\t\tv.buildings\r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE \r\n\t\t\t\tv.is_capital=0 AND v.is_special_village=1\r\n\t\t\tORDER BY\r\n\t\t\t\tv.id ASC" );
    }

    public function getPlayerListCount( $tribeId )
    {
        return $tribeId == 0 ? $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE\r\n\t\t\t\t\tp.player_type!=%s", array(
            PLAYERTYPE_TATAR
        ) ) : $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE\r\n\t\t\t\t\tp.player_type!=%s AND p.tribe_id=%s", array(
            PLAYERTYPE_TATAR,
            $tribeId
        ) );
    }

    public function getPlayerList( $pageIndex, $pageSize, $tribeId )
    {
        return $tribeId == 0 ? $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\t\tp.id,\r\n\t\t\t\t\tp.player_type,\r\n\t\t\t\t\tp.is_blocked,\r\n\t\t\t\t\tp.gold_num,\r\n\t\t\t\t\tp.name,\r\n\t\t\t\t\tp.alliance_id,\r\n\t\t\t\t\tp.alliance_name,\r\n\t\t\t\t\tp.total_people_count,\r\n\t\t\t\t\tp.villages_count\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE \r\n\t\t\t\t\tp.player_type!=%s\r\n\t\t\t\tORDER BY\r\n\t\t\t\t\t(p.total_people_count*10+p.villages_count) DESC, p.id ASC\r\n\t\t\t\tLIMIT %s,%s", array(
            PLAYERTYPE_TATAR,
            $pageIndex * $pageSize,
            $pageSize
        ) ) : $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\t\tp.id,\r\n\t\t\t\t\tp.player_type,\r\n\t\t\t\t\tp.is_blocked,\r\n\t\t\t\t\tp.gold_num,\r\n\t\t\t\t\tp.name,\r\n\t\t\t\t\tp.alliance_id,\r\n\t\t\t\t\tp.alliance_name,\r\n\t\t\t\t\tp.total_people_count,\r\n\t\t\t\t\tp.villages_count\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE \r\n\t\t\t\t\tp.player_type!=%s AND p.tribe_id=%s\r\n\t\t\t\tORDER BY\r\n\t\t\t\t\t(p.total_people_count*10+p.villages_count) DESC, p.id ASC\r\n\t\t\t\tLIMIT %s,%s", array(
            PLAYERTYPE_TATAR,
            $tribeId,
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getPlayerRankById( $playerId, $tribeId )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\t(p.total_people_count*10+p.villages_count) score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.id=%s\r\n\t\t\t\tAND p.player_type!=%s\r\n\t\t\tLIMIT 1", array(
            $playerId,
            PLAYERTYPE_TATAR
        ) );
        return $this->getPlayerRank( $row['id'], $row['score'], $tribeId );
    }

    public function getPlayerRankByName( $playerName, $tribeId )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\t(p.total_people_count*10+p.villages_count) score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.player_type!=%s\r\n\t\t\t\tAND p.name LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            PLAYERTYPE_TATAR,
            $playerName
        ) );
        return $this->getPlayerRank( $row['id'], $row['score'], $tribeId );
    }

    public function getPlayerRank( $playerId, $score, $tribeId )
    {
        $score = intval( $score );
        $playerId = intval( $playerId );
        $tribeId = intval( $tribeId );
        return $tribeId == 0 ? $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t\t(SELECT\r\n\t\t\t\t\t\tCOUNT(*)\r\n\t\t\t\t\tFROM p_players p\r\n\t\t\t\t\tWHERE p.player_type!=%s AND (p.total_people_count*10+p.villages_count)>%s) \r\n\t\t\t\t\t+\r\n\t\t\t\t\t(SELECT \r\n\t\t\t\t\t\tCOUNT(*)\r\n\t\t\t\t\tFROM p_players p\r\n\t\t\t\t\tWHERE p.player_type!=%s \r\n\t\t\t\t\t\tAND p.id<%s \r\n\t\t\t\t\t\tAND (p.total_people_count*10+p.villages_count)=%s)\r\n\t\t\t\t) + 1 rank", array(
            PLAYERTYPE_TATAR,
            $score,
            PLAYERTYPE_TATAR,
            $playerId,
            $score
        ) ) : $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t\t(SELECT\r\n\t\t\t\t\t\tCOUNT(*)\r\n\t\t\t\t\tFROM p_players p\r\n\t\t\t\t\tWHERE p.player_type!=%s AND (p.total_people_count*10+p.villages_count)>%s AND p.tribe_id=%s) \r\n\t\t\t\t\t+\r\n\t\t\t\t\t(SELECT \r\n\t\t\t\t\t\tCOUNT(*)\r\n\t\t\t\t\tFROM p_players p\r\n\t\t\t\t\tWHERE p.player_type!=%s \r\n\t\t\t\t\t\tAND p.id<%s \r\n\t\t\t\t\t\tAND (p.total_people_count*10+p.villages_count)=%s AND p.tribe_id=%s)\r\n\t\t\t\t) + 1 rank", array(
            PLAYERTYPE_TATAR,
            $score,
            $tribeId,
            PLAYERTYPE_TATAR,
            $playerId,
            $score,
            $tribeId
        ) );
    }

    public function getVillageListCount( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE\r\n\t\t\t\tNOT ISNULL(v.player_id)\r\n\t\t\t\tAND v.is_oasis=0" );
    }

    public function getVillagesList( $pageIndex, $pageSize )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\tv.id,\r\n\t\t\t\tv.player_id,\r\n\t\t\t\tv.village_name,\r\n\t\t\t\tv.player_name,\r\n\t\t\t\tv.people_count,\r\n\t\t\t\tv.rel_x,\r\n\t\t\t\tv.rel_y\r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE\r\n\t\t\t\tNOT ISNULL(v.player_id)\r\n\t\t\t\tAND v.is_oasis=0\r\n\t\t\tORDER BY\r\n\t\t\t\tv.people_count DESC, v.id DESC\r\n\t\t\tLIMIT %s,%s", array(
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getVillageRankByName( $villageName )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tv.id,\r\n\t\t\t\t(v.people_count) score\r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE \r\n\t\t\t\tNOT ISNULL(v.player_id)\r\n\t\t\t\tAND v.is_oasis=0\r\n\t\t\t\tAND v.village_name LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            $villageName
        ) );
        return $this->getVillageRank( $row['id'], $row['score'] );
    }

    public function getVillageRankById( $villageId )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tv.id,\r\n\t\t\t\t(v.people_count) score\r\n\t\t\tFROM p_villages v\r\n\t\t\tWHERE \r\n\t\t\t\tv.id=%s\r\n\t\t\t\tAND NOT ISNULL(v.player_id)\r\n\t\t\t\tAND v.is_oasis=0\r\n\t\t\tLIMIT 1", array(
            $villageId
        ) );
        return $this->getVillageRank( $row['id'], $row['score'] );
    }

    public function getVillageRank( $villageId, $score )
    {
        $score = intval( $score );
        $villageId = intval( $villageId );
        return $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t(SELECT\r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_villages v\r\n\t\t\t\tWHERE \r\n\t\t\t\t\tNOT ISNULL(v.player_id)\r\n\t\t\t\t\tAND v.is_oasis=0\r\n\t\t\t\t\tAND v.people_count>%s)\r\n\t\t\t\t+\r\n\t\t\t\t(SELECT \r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_villages v\r\n\t\t\t\tWHERE \r\n\t\t\t\t\tNOT ISNULL(v.player_id)\r\n\t\t\t\t\tAND v.is_oasis=0\r\n\t\t\t\t\tAND v.people_count=%s\r\n\t\t\t\t\tAND v.id>%s)\r\n\t\t\t) + 1 rank", array(
            $score,
            $score,
            $villageId
        ) );
    }

    public function getAllianceListCount( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\tFROM p_alliances a" );
    }

    public function getAlliancesList( $pageIndex, $pageSize )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\ta.name,\r\n\t\t\t\ta.player_count,\r\n\t\t\t\ta.rating\r\n\t\t\tFROM p_alliances a\r\n\t\t\tORDER BY\r\n\t\t\t\ta.rating DESC, a.player_count DESC, a.id ASC\r\n\t\t\tLIMIT %s,%s", array(
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getAllianceRankByName( $allianceName )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\t(a.rating*100+a.player_count) score\r\n\t\t\tFROM p_alliances a\r\n\t\t\tWHERE\r\n\t\t\t\ta.name LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            $allianceName
        ) );
        return intval( $row['id'] ) == 0 ? 0 : $this->getAllianceRank( intval( $row['id'] ), intval( $row['score'] ) );
    }

    public function getAllianceRankById( $allianceId )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\t(a.rating*100+a.player_count) score\r\n\t\t\tFROM p_alliances a\r\n\t\t\tWHERE \r\n\t\t\t\ta.id=%s\r\n\t\t\tLIMIT 1", array(
            $allianceId
        ) );
        return intval( $row['id'] ) == 0 ? 0 : $this->getAllianceRank( intval( $row['id'] ), intval( $row['score'] ) );
    }

    public function getAllianceRank( $allianceId, $score )
    {
        return $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t(SELECT\r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_alliances a\r\n\t\t\t\tWHERE \r\n\t\t\t\t\t(a.rating*100+a.player_count)>%s)\r\n\t\t\t\t+\r\n\t\t\t\t(SELECT \r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_alliances a\r\n\t\t\t\tWHERE \r\n\t\t\t\t\t(a.rating*100+a.player_count)=%s\r\n\t\t\t\t\tAND a.id<%s)\r\n\t\t\t) + 1 rank", array(
            $score,
            $score,
            $allianceId
        ) );
    }

    public function getHeroListCount( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE\r\n\t\t\t\tp.player_type!=%s\r\n\t\t\t\tAND p.hero_troop_id>0", array(
            PLAYERTYPE_TATAR
        ) );
    }

    public function getHerosList( $pageIndex, $pageSize )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.name,\r\n\t\t\t\tp.hero_troop_id,\r\n\t\t\t\tp.hero_level,\r\n\t\t\t\tp.hero_points,\r\n\t\t\t\tIFNULL(p.hero_name, p.name) hero_name\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE\r\n\t\t\t\tp.player_type!=%s\r\n\t\t\t\tAND p.hero_troop_id>0\r\n\t\t\tORDER BY\r\n\t\t\t\t(p.hero_points*10+p.hero_level) DESC, p.id ASC\r\n\t\t\tLIMIT %s,%s", array(
            PLAYERTYPE_TATAR,
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getHeroRankById( $playerId )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.hero_troop_id,\r\n\t\t\t\t(p.hero_points*10+p.hero_level) score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.id=%s\r\n\t\t\t\tAND p.player_type!=%s\r\n\t\t\t\tAND p.hero_troop_id>0\r\n\t\t\tLIMIT 1", array(
            $playerId,
            PLAYERTYPE_TATAR
        ) );
        return intval( $row['hero_troop_id'] ) == 0 ? 0 : $this->getHeroRank( $row['id'], $row['score'] );
    }

    public function getHeroRankByName( $playerName )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.hero_troop_id,\r\n\t\t\t\t(p.hero_points*10+p.hero_level) score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.player_type!=%s\r\n\t\t\t\tAND p.hero_troop_id>0\r\n\t\t\t\tAND IFNULL(p.hero_name, p.name) LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            PLAYERTYPE_TATAR,
            $playerName
        ) );
        return intval( $row['hero_troop_id'] ) == 0 ? 0 : $this->getHeroRank( $row['id'], $row['score'] );
    }

    public function getHeroRank( $playerId, $score )
    {
        $score = intval( $score );
        $playerId = intval( $playerId );
        return $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t(SELECT\r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE \r\n\t\t\t\t\t(p.hero_points*10+p.hero_level)>%s\r\n\t\t\t\t\tAND p.player_type!=%s AND p.hero_troop_id>0)\r\n\t\t\t\t+\r\n\t\t\t\t(SELECT \r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE\r\n\t\t\t\t\t(p.hero_points*10+p.hero_level)=%s\r\n\t\t\t\t\tAND p.id<%s\r\n\t\t\t\t\tAND p.player_type!=%s AND p.hero_troop_id>0)\r\n\t\t\t) + 1 rank", array(
            $score,
            PLAYERTYPE_TATAR,
            $score,
            $playerId,
            PLAYERTYPE_TATAR
        ) );
    }

    public function getGeneralSummary( )
    {
        $sessionTimeoutInSeconds = $GLOBALS['GameMetadata']['session_timeout'] * 60;
        $row = $this->provider->fetchRow( "SELECT gs.players_count, gs.active_players_count, gs.Dboor_players_count, gs.Arab_players_count, gs.Roman_players_count, gs.Teutonic_players_count, gs.Gallic_players_count FROM g_summary gs" );
        $row['online_players_count'] = $this->provider->fetchScalar( "SELECT COUNT(*) FROM p_players p WHERE TIME_TO_SEC(TIMEDIFF(NOW(), p.last_login_date)) <= %s", array(
            $sessionTimeoutInSeconds
        ) );
        return $row;
    }

    public function getPlayersPointsListCount( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE\r\n\t\t\t\tp.player_type!=%s", array(
            PLAYERTYPE_TATAR
        ) );
    }

    public function getPlayersPointsList( $pageIndex, $pageSize, $isDefense )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.name,\r\n\t\t\t\tp.total_people_count,\r\n\t\t\t\tp.villages_count,\r\n\t\t\t\tp.%s points\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.player_type!=%s\r\n\t\t\tORDER BY\r\n\t\t\t\t(p.%s) DESC, p.id ASC\r\n\t\t\tLIMIT %s,%s", array(
            $isDefense ? "defense_points" : "attack_points",
            PLAYERTYPE_TATAR,
            $isDefense ? "defense_points" : "attack_points",
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getPlayersPointsById( $playerId, $isDefense )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.%s score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.id=%s\r\n\t\t\t\tAND p.player_type!=%s\r\n\t\t\tLIMIT 1", array(
            $isDefense ? "defense_points" : "attack_points",
            $playerId,
            PLAYERTYPE_TATAR
        ) );
        return $this->getPlayersPointsRank( $row['id'], $row['score'], $isDefense );
    }

    public function getPlayersPointsByName( $playerName, $isDefense )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\tp.id,\r\n\t\t\t\tp.%s score\r\n\t\t\tFROM p_players p\r\n\t\t\tWHERE \r\n\t\t\t\tp.player_type!=%s\r\n\t\t\t\tAND p.name LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            $isDefense ? "defense_points" : "attack_points",
            PLAYERTYPE_TATAR,
            $playerName
        ) );
        return $this->getPlayersPointsRank( $row['id'], $row['score'], $isDefense );
    }

    public function getPlayersPointsRank( $playerId, $score, $isDefense )
    {
        $score = intval( $score );
        $playerId = intval( $playerId );
        return $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t(SELECT\r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE p.player_type!=%s AND p.%s>%s)\r\n\t\t\t\t+\r\n\t\t\t\t(SELECT \r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_players p\r\n\t\t\t\tWHERE p.player_type!=%s AND p.id<%s AND p.%s=%s)\r\n\t\t\t) + 1 rank", array(
            PLAYERTYPE_TATAR,
            $isDefense ? "defense_points" : "attack_points",
            $score,
            PLAYERTYPE_TATAR,
            $playerId,
            $isDefense ? "defense_points" : "attack_points",
            $score
        ) );
    }

    public function getAlliancePointsListCount( )
    {
        return $this->provider->fetchScalar( "SELECT COUNT(*) \r\n\t\t\tFROM p_alliances a" );
    }

    public function getAlliancePointsList( $pageIndex, $pageSize, $isDefense )
    {
        return $this->provider->fetchResultSet( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\ta.name,\r\n\t\t\t\ta.player_count,\r\n\t\t\t\ta.%s points\r\n\t\t\tFROM p_alliances a\r\n\t\t\tORDER BY\r\n\t\t\t\ta.%s DESC, a.id ASC\r\n\t\t\tLIMIT %s,%s", array(
            $isDefense ? "defense_points" : "attack_points",
            $isDefense ? "defense_points" : "attack_points",
            $pageIndex * $pageSize,
            $pageSize
        ) );
    }

    public function getAlliancePointsRankByName( $allianceName, $isDefense )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\ta.%s score\r\n\t\t\tFROM p_alliances a\r\n\t\t\tWHERE\r\n\t\t\t\ta.name LIKE '%s%%'\r\n\t\t\tLIMIT 1", array(
            $isDefense ? "defense_points" : "attack_points",
            $allianceName
        ) );
        return intval( $row['id'] ) == 0 ? 0 : $this->getAlliancePointsRank( intval( $row['id'] ), intval( $row['score'] ), $isDefense );
    }

    public function getAlliancePointsRankById( $allianceId, $isDefense )
    {
        $row = $this->provider->fetchRow( "SELECT \r\n\t\t\t\ta.id,\r\n\t\t\t\ta.%s score\r\n\t\t\tFROM p_alliances a\r\n\t\t\tWHERE \r\n\t\t\t\ta.id=%s\r\n\t\t\tLIMIT 1", array(
            $isDefense ? "defense_points" : "attack_points",
            $allianceId
        ) );
        return intval( $row['id'] ) == 0 ? 0 : $this->getAlliancePointsRank( intval( $row['id'] ), intval( $row['score'] ), $isDefense );
    }

    public function getAlliancePointsRank( $allianceId, $score, $isDefense )
    {
        return $this->provider->fetchScalar( "SELECT (\r\n\t\t\t\t(SELECT\r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_alliances a\r\n\t\t\t\tWHERE \r\n\t\t\t\t\ta.%s>%s)\r\n\t\t\t\t+\r\n\t\t\t\t(SELECT \r\n\t\t\t\t\tCOUNT(*)\r\n\t\t\t\tFROM p_alliances a\r\n\t\t\t\tWHERE \r\n\t\t\t\t\ta.%s=%s\r\n\t\t\t\t\tAND a.id<%s)\r\n\t\t\t) + 1 rank", array(
            $isDefense ? "defense_points" : "attack_points",
            $score,
            $isDefense ? "defense_points" : "attack_points",
            $score,
            $allianceId
        ) );
    }

    public function getTop10( $isPlayer, $columnName )
    {
        return $this->provider->fetchResultSet( "SELECT\r\n\t\t\t\tt.id,\r\n\t\t\t\tt.name,\r\n\t\t\t\tt.%s points\r\n\t\t\tFROM %s t\r\n\t\t\tWHERE \r\n\t\t\t\tt.%s>0\r\n\t\t\tORDER BY\r\n\t\t\t\tt.%s DESC, t.id ASC\r\n\t\t\tLIMIT 10", array(
            $columnName,
            $isPlayer ? "p_players" : "p_alliances",
            $columnName,
            $columnName
        ) );
    }

    public function getAlliancePoint( $id, $columnName )
    {
        return $this->provider->fetchScalar( "SELECT t.%s points FROM p_alliances t WHERE t.id=%s", array(
            $columnName,
            $id
        ) );
    }

    public function getPlayerType( $playerId )
    {
        return $this->provider->fetchScalar( "SELECT p.player_type FROM p_players p WHERE p.id=%s", array(
            $playerId
        ) );
    }

    public function togglePlayerStatus( $playerId )
    {
        $this->provider->executeQuery( "UPDATE p_players p\r\n\t\t\tSET\r\n\t\t\t\tp.is_blocked=IF(p.is_blocked=1, 0, 1)\r\n\t\t\tWHERE \r\n\t\t\t\tp.id=%s AND p.player_type=%s", array(
            $playerId,
            PLAYERTYPE_NORMAL
        ) );
    }

    public function setPlayerGold( $playerId, $goldNum )
    {
        $this->provider->executeQuery( "UPDATE p_players p\r\n\t\t\tSET\r\n\t\t\t\tp.gold_num=%s\r\n\t\t\tWHERE \r\n\t\t\t\tp.id=%s", array(
            $goldNum,
            $playerId
        ) );
    }

}

?>
