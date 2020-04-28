import { http, httpFile } from './http_service';

export function createTest(data) {
    return httpFile().post('/test', data)
}

