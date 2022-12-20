import { TestBed } from '@angular/core/testing';

import { ConsultasSparkService } from './consultas-spark.service';

describe('ConsultasSparkService', () => {
  let service: ConsultasSparkService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConsultasSparkService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
