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

==================
import fs from 'fs';
import winston from 'winston';
import winstonDaily from 'winston-daily-rotate-file';

// logs dir, make sure the log directory exists on the filesystem
const logDir = process.env.LOG_DIR || __dirname + '/../logs';

if (!fs.existsSync(logDir)) {
  fs.mkdirSync(logDir);
}

// Define log format
const logFormat = winston.format.printf(({ timestamp, level, message }) => `${timestamp} ${level}: ${message}`);

/*
 * Log Level
 * error: 0, warn: 1, info: 2, http: 3, verbose: 4, debug: 5, silly: 6
 */
const logger = winston.createLogger({
  format: winston.format.combine(
    winston.format.timestamp({
      format: 'YYYY-MM-DD HH:mm:ss',
    }),
    logFormat,
  ),
  transports: [
    // debug log setting
    new winstonDaily({
      level: 'debug',
      datePattern: 'YYYY-MM-DD',
      dirname: logDir + '/debug', // log file /logs/debug/*.log in save
      filename: `%DATE%.log`,
      maxFiles: 30, // 30 Days saved
      json: false,
      zippedArchive: true,
    }),
    // error log setting
    new winstonDaily({
      level: 'error',
      datePattern: 'YYYY-MM-DD',
      dirname: logDir + '/error', // log file /logs/error/*.log in save
      filename: `%DATE%.log`,
      maxFiles: 30, // 30 Days saved
      handleExceptions: true,
      json: false,
      zippedArchive: true,
    }),
  ],
});

logger.add(
  new winston.transports.Console({
    format: winston.format.combine(winston.format.splat(), winston.format.colorize()),
  }),
);

const stream = {
  write: (message: string) => {
    logger.info(message.substring(0, message.lastIndexOf('\n')));
  },
};

export { logger, stream };
=====


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
