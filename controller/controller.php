<?php 
session_status() === PHP_SESSION_ACTIVE ?: session_start();
/**
 * Load login webpage.
 */
function login(){
  require('view/authentication/login.php');
}

function signup() {
  require('view/authentication/signup.php');
}

function resetPwd() {
  require('view/authentication/resetPwd.php');
}

function check() {
  require('model/authentication/check.php');
}

function register() {
  require('model/authentication/signup.php');
}

function changePwd() {
  require('model/authentication/resetPwd.php');
}

function home() {
  require('view/home.php');
}

function showCompetition() {
  require('view/showCompetition.php');
}

function participate() {
  require('view/participate.php');
}

function insertNovella() {
  require('model/addNovella.php');
}

function test() {
  require('view/test.php');
function pageOrganisateur() {
  require('view/organisateur/pageOrganisateur.php');
}

function newCompetition() {
  require('view/organisateur/newCompetition.php');
}

function addCompetition() {
  require('model/organisateur/addCompetition.php');
}

function manageUser() {
  require('view/organisateur/manageUser.php');
}

function setCompetitionJurors() {
  require('model/organisateur/setCompetitionJurors.php');
}

?>