#!/usr/bin/env python3
from typing import List

class Figure():
    col: int   # Position der Figur (Spalte/Reihe)
    row: int   # als Wert von 0 bis 7

    # Konstruktor
    def __init__(self, pos: str):
        if len(pos) != 2: 
            raise ValueError('Ungültige Position')
        c = pos[0].lower() # column, z. B. 'c'
        r = pos[1]         # row,    z. B. '3'
        if (not c in 'abcdefgh') or (not r in '12345678'):
            raise ValueError('Ungültige Position')          
        self.col = 'abcdefgh'.find(c)
        self.row = '12345678'.find(r)
        
    # Position in Schachnotation zurückgeben
    def __str__(self):
        return Figure.position(self.col, self.row)
        
    # testen, ob gültige Position; liefert 
    # Schachnotation (z.B. 'e3') oder leere Zeichenk.
    @staticmethod
    def position(col: int, row: int) -> str:
        if row<0 or row>7 or col<0 or col>7:
          return ''
        return 'abcdefgh'[col] + '12345678'[row]

# Klasse für Pferd/Springer
class Knight(Figure):
    def __init__(self, pos: str):
        super().__init__(pos)
  
    def __str__(self):
        return 'Knight@' + Figure.position(self.col, self.row)

    # alle gültigen Ziele finden
    def findMoves(self) -> List[str]:
        offsets = [(1,2),  (2,1),  (-1,2),  (-2,1),
                   (1,-2), (2,-1), (-1,-2), (-2,-1)]
        positions = []
        for (coff,roff) in offsets:
            newpos = Figure.position(self.col + coff, 
                                     self.row + roff)
            if newpos:
                positions += [newpos]
        return positions

# Klasse für Läufer
class Bishop(Figure):
    def __init__(self, pos: str):
        super().__init__(pos)
  
    def __str__(self):
        return 'Bishop@' + Figure.position(self.col, self.row)

    def findMoves(self) -> List[str]:
        positions = []
        for i in range(-7, 8):
            if i==0: 
                continue
            # Diagonale von links unten nach rechts oben
            newpos = Figure.position(self.col + i, 
                                     self.row + i)
            if newpos:
                positions += [newpos]
            # Diagonale von rechts unten nach links oben
            newpos = Figure.position(self.col + i, 
                                     self.row - i)
            if newpos:
                positions += [newpos]
        return positions


# Klasse für Turm
class Rook(Figure):
    def __init__(self, pos: str):
        super().__init__(pos)
  
    def __str__(self):
        return 'Rook@' + Figure.position(self.col, self.row)

    def findMoves(self) -> List[str]:
        positions = []
        for i in range(-7, 8):
            if i==0: 
                continue
            # von links nach rechts
            newpos = Figure.position(self.col + i, 
                                     self.row)
            if newpos:
                positions += [newpos]
            # von unten nach oben
            newpos = Figure.position(self.col, 
                                     self.row + i)
            if newpos:
                positions += [newpos]
        return positions

# Klasse für Dame
class Queen(Figure):
    def __init__(self, pos: str):
        super().__init__(pos)
  
    def __str__(self):
        return 'Queen@' + Figure.position(self.col, self.row)

    def findMoves(self) -> List[str]:
        positions = []
        for i in range(-7, 8):
            if i==0: continue
            # von links nach rechts
            newpos = Figure.position(self.col + i, self.row)
            if newpos: positions += [newpos]
            # von unten nach oben
            newpos = Figure.position(self.col, self.row + i)
            if newpos: positions += [newpos]
            # Diagonale von links unten nach rechts oben
            newpos = Figure.position(self.col + i, self.row + i)
            if newpos: positions += [newpos]
            # Diagonale von rechts unten nach links oben
            newpos = Figure.position(self.col + i, self.row - i)
            if newpos: positions += [newpos]
        return positions

# Klasse für König
class King(Figure):
    def __init__(self, pos: str):
        super().__init__(pos)

    def __str__(self):
        return 'King@' + Figure.position(self.col, self.row)

    def findMoves(self) -> List[str]:
        positions = []
        for i in range(-1, 2):
            if i==0: continue
            # von links nach rechts
            newpos = Figure.position(self.col + i, self.row)
            if newpos: positions += [newpos]
            # von unten nach oben
            newpos = Figure.position(self.col, self.row + i)
            if newpos: positions += [newpos]
            # Diagonale von links unten nach rechts oben
            newpos = Figure.position(self.col + i, self.row + i)
            if newpos: positions += [newpos]
            # Diagonale von rechts unten nach links oben
            newpos = Figure.position(self.col + i, self.row - i)
            if newpos: positions += [newpos]
        return positions

# Klasse für Bauern
class Pawn(Figure):
    def __init__(self, color: str, pos: str):
        self.color = color
        super().__init__(pos)
        allowed_colors = ["white", "black"]
        if self.color not in allowed_colors:
            raise ValueError('Ungültige Farbe ' + self.color + ' Erlaubte Farben white|black')

    def __str__(self):
        return self.color + ' Pawn@' + Figure.position(self.col, self.row)

    def findMoves(self) -> List[str]:
        positions = []
        pos = Figure.position(self.col, self.row)
        row = pos[1]
        print(row)
        if row == '2' or row == '7':
            step = 3
        else:
            step = 2
        print(step)

        if self.color == 'white':
            for i in range(step):
                if i==0: continue
                # von unten nach oben
                newpos = Figure.position(self.col, self.row + i)
                if newpos: positions += [newpos]
        elif self.color == 'black':
            for i in range(step):
                if i==0: continue
                # von oben nach unten
                newpos = Figure.position(self.col, self.row -i)
                if newpos: positions += [newpos]
        return positions

# Anwendung    
figures = [Knight('e5'), Bishop('b3'), Rook('a1'), Queen('d8'), King('d1'), Pawn('white', 'b2'), Pawn('black', 'd7'), Pawn('white', 'c5')]
#figures = [Knight('e5'), Bishop('b3'), Rook('a1'), Queen('d8'), King('d1'), Pawn('white', 'b2'), Pawn('black', 'c4')]
#figures = [Knight('e5'), Bishop('b3'), Rook('a1'), Queen('d8')]
for f in figures:
    print(f, f.findMoves())
