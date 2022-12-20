import { Component, OnInit } from '@angular/core';
import { ConsultasSparkService } from './consultas-spark.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  title = 'tableRefresh';

  datos: any;

  constructor(private servicio: ConsultasSparkService) { }

  ngOnInit() {
    
    this.servicio.show().subscribe(res => {
      this.datos = Object.values(res);

      setTimeout(() => {
        this.ngOnInit();
      }, 10000);
      
        
    });


}
}
