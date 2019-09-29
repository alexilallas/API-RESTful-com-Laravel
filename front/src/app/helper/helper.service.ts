import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class HelperService {

  constructor() { }

  async delay(ms: number) {
    await new Promise(resolve => setTimeout(() => resolve(), ms));
  }
}
