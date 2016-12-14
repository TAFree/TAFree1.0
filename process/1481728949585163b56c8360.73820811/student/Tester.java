import java.util.Scanner;
import java.lang.Math;

public class Tester {
 
   public static void main(String[] args) {
            
            Scanner scanner = new Scanner(System.in);
            System.out.print("Please input a 2 character student code: ");
            String in = scanner.nextLine();
            if (in.length() > 2) {
                System.out.println("Input is more than two characters!");
		return;
                
            }
            String subject;
            String year;
            int i = (int)(Math.random() * 10);
            if (i % 2 == 0) {
                subject = "Civil Engineering";
                year = "*";
            }
            else {
                subject = "Civil Engineering";
                year = "**";
            }

            
            System.out.printf("The student majors in %s,\nand is in year: %s.\n", subject, year);
	    
    }

}
