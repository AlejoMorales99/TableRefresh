import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ConsultasSparkService {

  constructor(private http: HttpClient) { }
  
  private url = "http://localhost/consultaMySql/app/controllers/consultaController.php";


  show() {
    return this.http.get(this.url);
  }





}
