class Square extends GeometricObject{
	double side;
	Square(double side){
		this.side = side;
	}
	public double getArea(){
		return side*side;
	}

	public double getPerimeter(){
		return 4*side;
	}
	
	public void howToColor(){
		System.out.println("Color all four sides");
	}
}