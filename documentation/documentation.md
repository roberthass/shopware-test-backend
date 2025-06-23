# Dokumentation

## 2. Shopware mittels Docker aufsetzen

Ich habe mich wegen der Einfachheit für das dockware Image entschieden mit dem play Tag. 
Dort ist bereits Shopware 6 und alles enthalten, was Shopware zum Laufen braucht. 
Ebenso ist es vorkonfiguriert und enthält bereits Produkte.
Der Store von Shopware ist unter http://localhost erreichbar und die Administration unter http://localhost/admin. 

### Admin Zugangsdaten
- User: admin
- Passwort: shopware


## 1. Symfony Backend aufsetzen

Ich habe mich dafür entschieden die Zweite Aufgabe, vor der ersten zu machen da die zweite Aufgabe komplett für sich alleine steht und die Voraussetzung für alle weiteren Aufgaben ist.

Ich habe mich für Symfony 7.3 entschieden, weil es die aktuellste Version ist und es "nur" ein Demoprojekt ist.
Bei einer Entscheidung für ein Produktiv-System sollte man abwägen, ob die LTS (aktuell 6.4) nicht besser geeignet. 
Oder ob man eine Halbjährlichen Maintenance/Update Zyklus mitmachen kann. 
Ebenso wäre API-Platform für diese Aufgabe eine denkbare Lösung gewesen, aber ich denke nicht sehr aussagekräftig.

Mein Basis-Symfony Backend enthält bereits das symfony/test-pack als dev Abhängigkeit damit von Anfang an Test geschrieben werden können.

Nach dem Aufsetzen des Basis-Symfony-Backends würde ich mich als Nächstes um eine CI/CD Pipeline kümmern. 
Damit mein Projekt bei jedem Commit automatisch getestet wird und es auch auf eine mögliche Dev- oder Staging-Umgebung ausgerollt werden kann ohne manuellen Aufwand. 
