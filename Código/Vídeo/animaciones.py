from manim import *

class Portada(Scene): 
    def construct(self):
        tituloAsignatura=Tex("COMPUTACIÓN UBICUA").to_edge(UP, buff=0.75)
        tituloTrabajo=Tex("\\textit{Sistema de gestión de puestos de estudio}")
        tituloTrabajo2=Tex("\\textit{STUBIA}")
        logo=SVGMobject("uah").scale(1.2)

        integrantes=["Carlos Javier Prado Vázquez", "Guillermo González Martínez", "Pablo García García", "Robert Petrisor"]
        integrantesTex=[]

        tituloTrabajo.next_to(tituloAsignatura, DOWN)
        tituloTrabajo2.next_to(tituloTrabajo, DOWN)
        logo.next_to(tituloTrabajo2, DOWN*2)

        for i in range(4): 
            integrantesTex.append(Tex("\\textit{"+integrantes[i]+"}").scale(0.75))

        integrantesTex[0].next_to(logo, DOWN, buff=0.35)

        for i in range(1, 4): 
            if(i==1):
                integrantesTex[i].next_to(integrantesTex[i-1], DOWN, buff=0.08)
            else: 
                integrantesTex[i].next_to(integrantesTex[i-1], DOWN, buff=0.2)
        
        self.play(Write(tituloAsignatura))
        self.play(TransformFromCopy(tituloAsignatura, tituloTrabajo))
        self.play(TransformFromCopy(tituloTrabajo, tituloTrabajo2))
        self.play(DrawBorderThenFill(logo, run_time=3.5))
        self.play(Write(integrantesTex[0]))
        self.play(FadeToColor(integrantesTex[0], YELLOW, run_time=0.3))
        self.play(ScaleInPlace(integrantesTex[0], 1.2, run_time=0.6))
        self.play(ScaleInPlace(integrantesTex[0], 0.8, run_time=0.6))
        self.play(FadeToColor(integrantesTex[0], WHITE, run_time=0.3))
        
        for i in range(1, 4): 
            self.play(TransformFromCopy(integrantesTex[i-1], integrantesTex[i]))
            self.play(FadeToColor(integrantesTex[i], YELLOW))
            self.play(ScaleInPlace(integrantesTex[i], 1.2, run_time=0.6))
            self.play(ScaleInPlace(integrantesTex[i], 0.8, run_time=0.6))
            self.play(FadeToColor(integrantesTex[i], WHITE))

        self.play(
            Unwrite(tituloAsignatura, reverse=False), 
            Unwrite(tituloTrabajo, reverse=False), 
            Unwrite(tituloTrabajo2, reverse=False), 
            Unwrite(logo, reverse=False), 
            Unwrite(integrantesTex[0], reverse=False), 
            Unwrite(integrantesTex[1], reverse=False), 
            Unwrite(integrantesTex[2], reverse=False), 
            Unwrite(integrantesTex[3], reverse=False)
            )

        self.wait()

class Nombres(Scene): 
    def construct(self): 
        self.camera.background_color = "#04ff00"
        n1=Tex("\\textit{Pablo García García}").set_stroke(BLACK, 2.5).scale(3)
        self.play(Write(n1))
        self.wait(3)
        self.play(Unwrite(n1))

        n2=Tex("\\textit{Guillermo González Martínez}").set_stroke(BLACK, 1.8).scale(2.2)
        self.play(Write(n2))
        self.wait(3)
        self.play(Unwrite(n2))

        n3=Tex("\\textit{Carlos Javier Prado Vázquez}").set_stroke(BLACK, 2).scale(2.2)
        self.play(Write(n3))
        self.wait(3)
        self.play(Unwrite(n3))

class Cierre(Scene): 
    def construct(self): 
        texto1=Tex("COMPUTACIÓN UBICUA 2022")
        texto2=Tex("Universidad de Alcalá")

        self.play(Write(texto1))
        self.wait(1.5)
        self.play(Transform(texto1, texto2))
        self.wait(1.5)
        self.play(FadeOut(texto1))