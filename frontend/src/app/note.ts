export class Note {
  title: string = '';
  content: string = '';
  category: string = '';
  date: Date;
  id: number;

  constructor(values: Object = {}) {
    Object.assign(this, values);
  }
}
