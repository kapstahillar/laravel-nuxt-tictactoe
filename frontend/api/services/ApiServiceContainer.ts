import ApplicationService from "./ApplicationService";
import type AuthService from "./AuthService";


export interface ApiServiceContainer {
    application: ApplicationService;
    authentication: AuthService;
}