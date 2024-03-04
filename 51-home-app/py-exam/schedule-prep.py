def read_dates(caption=''):
    dates = []
    print(f'***Enter {caption}:***')
    while True:
        aMonth = input('Enter month(YYYY-MM):')
        monthDates = [ f'{aMonth}-{format(int(e),"02d")}' for e in input('Dates(comma separated):').split(",")]
        dates.extend(monthDates)
        hasTocontinue = input("Continue(y/n):").lower() == 'y'
        if not hasTocontinue:
            break
    return dates

all_dates = [read_dates('Exam Dates'), read_dates('Holidays')]

print(all_dates)


'''
Exam Planner:

    {
        between: ['from','to'],
        subjects:[{subject:'Exam',date:'',chapters:[{'Ch 1-A B C D'}]},],
        holidays:[],
        study_plan: [{'date':'',subject:'',plan:''}]
    }

'''