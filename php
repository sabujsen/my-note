# Tracking
<?php
  //Step over if cookie is
  if (!isset($_COOKIE["SITE_VISITED"])) {  already set
    setcookie('SITE_VISITED', 'X');
    $db = mysqli_connect('localhost', 'bfu', '1234', 'visits');
    //Do we already have a record in the DB?
    $res = mysqli_query($db, sprintf("SELECT * FROM visits WHERE ipaddr='%s';",$_SERVER['REMOTE_ADDR']));
    if ($res === FALSE && $res->num_rows = 0) {
      //Record in DB not found, let's create one
      $res2 = mysqli_query($db, sprintf("INSERT INTO visits('ipaddr','page') VALUES ('%s','%s');",$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI']));
    }
    mysqli_close($res);
  }
?>
import { Router } from 'express';
import Route from '@interfaces/routes.interface';
import FooterController from '@controllers/FooterController';
import { autoInjectable } from 'tsyringe';

@autoInjectable()
class FooterRoute implements Route {
    public footerPath = '/api/footer/list';

    public router = Router();
    public footerController: FooterController;
    constructor(footerController: FooterController) {
        this.footerController = footerController;
        this.initializeRoutes();
    }

    private initializeRoutes() {
        this.router.get(`${this.footerPath}`, this.footerController.footerList);
    }
}

export default FooterRoute;
============================
import { Router } from 'express';
import Route from '@interfaces/routes.interface';
import UserAgentProfileController from '@controllers/UserAgentProfileController';
import { autoInjectable } from 'tsyringe';

@autoInjectable()
class UserAgentProfileRoute implements Route {
    public getUserAgentProfilePath = '/api/users/agent/profile/detail';
    public createUserAgentProfilePath = '/api/users/agents/profile/add';
    public updateUserAgentProfilePath = '/api/users/agents/profile/update';
    public router = Router();
    public userAgentProfileController: UserAgentProfileController;
    constructor(userAgentProfileController: UserAgentProfileController) {
        this.userAgentProfileController = userAgentProfileController;
        this.initializeRoutes();
    }

    private initializeRoutes() {
        this.router.get(`${this.getUserAgentProfilePath}`, this.userAgentProfileController.getUserAgentDetail);
        this.router.post(`${this.createUserAgentProfilePath}`, this.userAgentProfileController.createUserAgentProfile);
        this.router.put(`${this.updateUserAgentProfilePath}`, this.userAgentProfileController.updateUserAgentProfile);
    }
}

export default UserAgentProfileRoute;
===================
import { NextFunction, Request, Response } from "express";
import { injectable } from "tsyringe";
import { UserAgentProfileService } from "@services/userAgentProfile.service";

@injectable()
class UserAgentProfileController {
    
    userAgentProfileService:UserAgentProfileService;
    constructor(userAgentProfileService:UserAgentProfileService) {
        this.userAgentProfileService = userAgentProfileService;
    }

    public getUserAgentDetail = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
        try {
            let output = await this.userAgentProfileService.getUserAgentProfileDetail(req, res);
            res.status(200);
            res.json(output);
        } catch (error) {
            next(error);
        }
    }

    public createUserAgentProfile = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
        try {
            let output = await this.userAgentProfileService.createUserAgentProfile(req,res);
            res.status(200);
            res.json(output);
        } catch (error) {
            next(error);
        }
    }

    public updateUserAgentProfile = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
        try {
            let output = await this.userAgentProfileService.updateUserAgentProfile(req,res);
            res.status(200);
            res.json(output);
        } catch (error) {
            next(error);
        }
    }
}

export default UserAgentProfileController;
